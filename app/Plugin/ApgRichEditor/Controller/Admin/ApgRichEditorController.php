<?php

/*
 * This file is part of the ApgRichEditor
 *
 * Copyright (C) 2018 ARCHIPELAGO Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\ApgRichEditor\Controller\Admin;

use Eccube\Controller\AbstractController;
use Plugin\ApgRichEditor\Util\Paths;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApgRichEditorController extends AbstractController
{

    protected $paths;

    protected $entityManager;

    public function __construct(
        Paths    $paths,
        Packages $packages
    )
    {
        $this->paths = $paths;
        $this->packages = $packages;
    }

    /**
     * @Route("/%eccube_admin_route%/apg_rich_editor/editor/upload-image", name="plugin_ApgRichEditor_uploadImage")
     */
    public function uploadImage(Request $request)
    {


        $response = array();
        $error = null;
        $savedFile = null;
        $location = null;

        $image = $request->files->get('file');
        if (!empty($image)) {
            $mimeType = $image->getMimeType();
            if (0 !== strpos($mimeType, 'image')) {
                $error = '画像ファイルではありません';
            } else {

                $rootPath = $this->paths->editorImageBasePath() . 'rich_editor';
                $fs = new Filesystem();
                if (!$fs->exists($rootPath)) {
                    $fs->mkdir($rootPath);
                }

                $extension = $image->getClientOriginalExtension();
                $fileName = date('mdHis') . uniqid('_') . '.' . $extension;
                $image->move($rootPath, $fileName);
                $location = $this->packages->getUrl('rich_editor/' . $fileName, 'save_image');
            }
        } else {
            $error = '不正なファイル、またはサイズが大きすぎます。';
        }

        if (!is_null($error)) {
            $response['error'] = $error;
        } elseif (!is_null($location)) {
            $response['location'] = $location;
        }

        echo json_encode($response);
        exit;
    }

    /**
     * @Route("/%eccube_admin_route%/apg_rich_editor/editor/images", name="plugin_ApgRichEditor_images")
     * @Template("@ApgRichEditor/admin/images.twig")
     *
     * @param Request $request
     * @return mixed
     */
    public function images(Request $request)
    {
    }

    /**
     * ApgRichEditor画面
     *
     * @Route("/%eccube_admin_route%/apg_rich_editor/editor/elfinder-connector", name="plugin_ApgRichEditor_connect")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function connect(Request $request)
    {

        error_reporting(9); // Set E_ALL for debuging

// load composer autoload before load elFinder autoload If you need composer
//require './vendor/autoload.php';

// elFinder autoload
        require $this->eccubeConfig->get('plugin_realdir') . '/ApgRichEditor/Resource/assets/vendors/elFinder-2.1.59/php/autoload.php';
// ===============================================

// Enable FTP connector netmount
        \elFinder::$netDrivers['ftp'] = 'FTP';
// ===============================================

        $rootPath = $this->paths->editorImageBasePath() . 'rich_editor';
        $fs = new Filesystem();
        if (!$fs->exists($rootPath)) {
            $fs->mkdir($rootPath);
        }
        $rootUrl = $this->packages->getUrl('rich_editor', 'save_image');


        $s = DIRECTORY_SEPARATOR;
        $opts = array(
            // 'debug' => true,
            'roots' => array(
                // Items volume
                array(
                    'driver' => 'LocalFileSystem',           // driver for accessing file system (REQUIRED)
                    'path' => $rootPath,                 // path to files (REQUIRED)
                    'URL' => $rootUrl, // URL to files (REQUIRED)
//                    'trashHash' => 't1_Lw',                     // elFinder's hash of trash folder
                    'winHashFix' => $s !== '/', // to make hash same to Linux one on windows too
                    'uploadDeny' => array('all'),                // All Mimetypes not allowed to upload
                    'uploadAllow' => array('image', 'text/plain', 'application/pdf'),// Mimetype `image` and `text/plain` allowed to upload
                    'uploadOrder' => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
                    'accessControl' => array($this, 'access'),
                    'encoding' => 'cp932' // 追加
                ),
//                // Trash volume
//                array(
//                    'id' => '1',
//                    'driver' => 'Trash',
//                    'path' => $rootPath . '/.trash',
//                    'URL' => $rootUrl, // URL to files (REQUIRED)
//                    'tmbURL' => $rootUrl . '/.trash/.tmb',
//                    'winHashFix' => $s !== '/', // to make hash same to Linux one on windows too
//                    'uploadDeny' => array('all'),                // Recomend the same settings as the original volume that uses the trash
//                    'uploadAllow' => array('image', 'text/plain', 'application/pdf'),// Same as above
//                    'uploadOrder' => array('deny', 'allow'),      // Same as above
//                    'accessControl' => array($this, 'access'),
//                )
            )
        );

// run elFinder
        $connector = new \elFinderConnector(new \elFinder($opts));
        $connector->run();

    }


    /**
     * Simple function to demonstrate how to control file access using "accessControl" callback.
     * This method will disable accessing files/folders starting from '.' (dot)
     *
     * @param string $attr attribute name (read|write|locked|hidden)
     * @param string $path absolute file path
     * @param string $data value of volume option `accessControlData`
     * @param object $volume elFinder volume driver object
     * @param bool|null $isDir path is directory (true: directory, false: file, null: unknown)
     * @param string $relpath file path relative to volume root directory started with directory separator
     * @return bool|null
     **/
    public function access($attr, $path, $data, $volume, $isDir, $relpath)
    {
        $basename = basename($path);
        return $basename[0] === '.'                  // if file/folder begins with '.' (dot)
        && strlen($relpath) !== 1           // but with out volume root
            ? !($attr == 'read' || $attr == 'write') // set read+write to false, other (locked+hidden) set to true
            : null;                                 // else elFinder decide it itself


    }

}
