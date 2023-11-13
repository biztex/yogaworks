/*配信履歴　ドーナツグラフ-------------------------------------------*/

//send_rate ： 配信率
//cv_rate ： cv率

function doughnutGraphCreate(send_rate,cv_rate){
	var send_rate_minus = 100 - send_rate;
	var cv_rate_minus = 100 - cv_rate;

	var ctx = document.getElementById("dnt01").getContext("2d");
	var myChart = new Chart(ctx, {
		type: 'doughnut',
		data: {
			labels: [],
			datasets: [{
				backgroundColor: [
					"#073152"
				],
				hoverBackgroundColor:[
					"#073152"
				],
				borderColor: 'transparent',
				data: [send_rate,send_rate_minus]
			}]
		}
		,options: {
			responsive: true,
			cutoutPercentage: 90,
			tooltips: {enabled: false},
			animation: {duration: 1500}
		}
	});
	var pie2 = document.getElementById("dnt02").getContext("2d");
	var myChart02 = new Chart(pie2, {
		type: 'doughnut',
		data: {
			labels: [],
			datasets: [{
				backgroundColor: [
					"#ffcb00"
				],
				hoverBackgroundColor: [
					"#ffcb00"
				],
				borderColor: 'transparent',
				data: [cv_rate,cv_rate_minus]
			}]
		}
		,options: {
			responsive: true,
			cutoutPercentage: 90,
			tooltips: {enabled: false},
			animation: {duration: 2000},
//			animation: {duration: 2000,easing: 'easeOutBounce'}
		}
	});
}

/*-------------------------------------------配信履歴　ドーナツグラフ*/

/*顧客別　複合グラフ-------------------------------------------*/

//cv_f ： CV率(女性)の配列 10,20,30,40,50,60代,その他 の7要素
//cv_m ： CV率(男性)の配列 10,20,30,40,50,60代,その他 の7要素
//clc_f ： クリック数(女性)の配列 10,20,30,40,50,60代,その他 の7要素
//clc_m ： クリック数(男性)の配列 10,20,30,40,50,60代,その他 の7要素

function mixGraphCreate(cv_f,cv_m,clc_f,clc_m){

	var max_cv = 0 ;
	var max_cv_step = 0 ;
	var max_cv_f = Math.max.apply(null,cv_f);
	var max_cv_m = Math.max.apply(null,cv_m);
	var max_clc = 0 ;
	var max_clc_step = 0 ;
	var max_clc_f = Math.max.apply(null,clc_f);
	var max_clc_m = Math.max.apply(null,clc_m);

	if(max_cv_f < max_cv_m){
		max_cv = max_cv_m;
	}else{
		max_cv = max_cv_f;
	}

	if(max_clc_f < max_clc_m){
		max_clc = max_clc_m;
	}else{
		max_clc = max_clc_f;
	}

	if(max_cv<25){
		max_cv = 25;
		max_cv_step = 5;
	}else if(max_cv<50){
		max_cv = 50;
		max_cv_step = 10;
	}else if(max_cv<75){
		max_cv = 75;
		max_cv_step = 15;
	}else{
		max_cv = 100;
		max_cv_step = 20;
	}

	if(max_clc<25){
		max_clc = 25;
		max_clc_step = 5;
	}else if(max_clc<50){
		max_clc = 50;
		max_clc_step = 10;
	}else if(max_clc<75){
		max_clc = 75;
		max_clc_step = 15;
	}else{
		max_clc = 100;
		max_clc_step = 20;
	}


/*
	max_cv_step =(max_cv/5).toFixed(2);
	max_clc_step =(max_clc/5).toFixed(2)
	max_cv = max_cv_step * 5;
	max_clc = max_clc_step * 5;

*/
	var barChartData = {
		labels: ['10代','20代','30代','40代','50代','60代','その他'],
		datasets: [
			{
				//CV女性
				type: 'line', // 追加
				data: cv_f,
				borderColor : "#ba1212",
				backgroundColor : "transparent",
				lineTension: 0,
				borderWidth:1,
				yAxisID: "y-axis-1",
				pointRadius: 3,
				pointBackgroundColor:"#ba1212",
				pointHoverRadius: 3,
			},
			{
				//CV男性
				type: 'line', // 追加
				data: cv_m,
				borderColor : "#073152",
				backgroundColor : "transparent",
				lineTension: 0,
				borderWidth:1,
				yAxisID: "y-axis-1",
				pointRadius: 3,
				pointBackgroundColor:"#073152",
				pointHoverRadius: 3,
			},
			{
				//クリック男性
				data: clc_m,
				borderColor : "#b9d9de",
				backgroundColor : "#b9d9de",
				hoverBackgroundColor: "#b9d9de",
				yAxisID: "y-axis-bar",
			},
			{
				//クリック女性
				data: clc_f,
				borderColor : "#eab7b7",
				backgroundColor : "#eab7b7",
				hoverBackgroundColor: "#eab7b7",
				yAxisID: "y-axis-bar",


			}
		]
	};

	var complexChartOption = {
		legend: {
		   display: false
		},
		tooltips: {enabled: false},
//		animation: {duration: 2000,easing: 'easeOutBounce'},
		scales: {
			yAxes: [
				{
				   id: "y-axis-bar",   // Y軸のID
					stacked: true,			  //積み上げ棒グラフの設定
					ticks: {		  // スケール
						max: max_clc,
						min: 0,
						stepSize: max_clc_step,
						callback: function(value, index, values) {
							if (value != 0){
								return  value.toLocaleString() + '%';
							}else{
								return  value.toLocaleString();
							}
						}
					},
					gridLines: {
						drawBorder: false,
						borderDash: [8, 4],
					},
				},
				{
					id: "y-axis-1",	// Y軸のID
					type: "linear",	// linear固定
					position: "right",	// どちら側に表示される軸か？
					scaleLabel: {
						labelString: '横軸ラベル'
					},
					ticks: {		  // スケール
						max: max_cv,
						min: 0,
						stepSize: max_cv_step,
						callback: function(value, index, values) {
							if (value != 0){
								return  value + '%';
							}else{
								return  value;
							}
						}
					},
					gridLines: {
						drawBorder: false,
						borderDash: [8, 4],
						color: '#e8edf1',
						zeroLineColor: '#e8edf1',
					}
				},
			]
			, xAxes: [
				{
					stacked: true,			   //積み上げ棒グラフにする設定
					 barThickness: 20,		//棒グラフの幅
					 scaleLabel: {			 // 軸ラベル
						display: false		  // 表示設定
						, fontSize: 16		  // フォントサイズ
					},
					gridLines: {
						display: false,

					}

				}

			]
		},

	};
	var ctx = document.getElementById("bar01").getContext("2d");
	ctx.canvas.height = 100;
	var myChart = new Chart(ctx, {
		type: 'bar', // ここは bar にする必要があります
		data: barChartData,
		options: complexChartOption,
	});
}


/*-------------------------------------------顧客別　複合グラフ*/

/*リンク別　棒グラフ-------------------------------------------*/
//max_cnt ： 全データの中で最大のクリック数
//cv_cnt ： CV数
//clc_cnt ： クリック数
//inc_cnt ： 1からのインクリメント値

function linkGraphCreate(max_clc_cnt,cv_cnt,clc_cnt,inc_cnt){
	if(cv_cnt >= clc_cnt){
		clc_cnt = 0;
	}else{
		clc_cnt = clc_cnt - cv_cnt;
	}
/*
	max_clc_cnt = max_clc_cnt - clc_cnt;
*/
	var barChartData = {
		labels: [""],//リンクパス
		datasets: [
			{
				data: [cv_cnt],//コンバージョン数
				borderColor : "#ffcb00",
				backgroundColor : "#ffcb00",
				hoverBackgroundColor: "#ffcb00",
			},
			{
				data: [clc_cnt],//クリック数
				borderColor : "#073152",
				backgroundColor : "#073152",
				hoverBackgroundColor: "#073152",
			},
			{
				data: [max_clc_cnt],//全データの中で最大のクリック数
				borderColor : "#e8edf1",
				backgroundColor : "#e8edf1",
				hoverBackgroundColor: "#e8edf1",
			},
		]
	};

	var complexChartOption = {
		legend: {
			display: false,
		},
		tooltips: {enabled: false},
		layout: {
			padding: {
				right: 30,
			}
		},
		scales: {
			yAxes: [
				{
					stacked: true,			  //積み上げ棒グラフの設定
					barThickness: 5,		//棒グラフの幅
					gridLines: {
						display: false,
						drawBorder: false,
					},
					scaleLabel: {
					},
					ticks: {		  // スケール
					}
				}
			]
			, xAxes: [
				{
					stacked: true,			   //積み上げ棒グラフにする設定
					ticks: {		  // スケール
						max: max_clc_cnt,// + cv_cnt + clc_cnt ,
						maxTicksLimit:7,
						callback: function(value, index, values) {
							if (value != 0){
								return  value.toLocaleString();
							}
						},
					display: false,
					},
					scaleLabel: {
						fontColor: "red",
					},

					gridLines: {
						display: false,
						drawBorder: false,
					}
				}
			]
		}
	};
	var inc_id = "hznBar" + inc_cnt;
	var ctx = document.getElementById(inc_id).getContext("2d");
	var myChart = new Chart(ctx, {
		type: 'horizontalBar',
		data: barChartData,
		options: complexChartOption,
	});
}
/*-------------------------------------------リンク別　棒グラフ*/

/*カウントアップ-------------------------------------------*/
function countUp(tgt,cnt){ //ターゲットのクラスの順番,カウントアップさせる数字
	var num = 0;
	var digits = String(Math.floor(cnt)).length;
	var speed = 1;
	var countDigits = 0;
	if(digits <= 1){
		if(cnt <= 1){
			countDigits = 0.01;
		}else{
			countDigits = 0.1;
		}
	}else if(digits <= 2){
		countDigits = 1;
	}else{
		digits = digits -2;
/*
		countDigits = 10**digits;
*/
		countDigits = Math.pow(10,digits);
	}

	var cue= document.getElementsByClassName('countUpElm');

	var interval_id = setInterval(function(){
		if(num <= cnt){
			cue[tgt].innerHTML = num.toLocaleString();
			num=num + countDigits;
		}else{
			cue[tgt].innerHTML = cnt.toLocaleString();
			clearInterval(interval_id);
		}
	},speed);

}
/*-------------------------------------------カウントアップ*/
