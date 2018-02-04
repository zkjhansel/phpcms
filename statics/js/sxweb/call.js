$(function(){

	//因为优惠团购特殊调用的原因，必须手动给第一个tab的li添加fst类名
	$('.content-discount .tit').find('li').eq(0).addClass('fst');
	/*
		移动式导航特效
	*/	
	function tabIndicator(options) {
		/*options
			wrap     : 选项卡和指示器所在容器
			twrap    : 选项卡所在容器类名或选择器
			iwrap    : 指示器所在容器类名
			initPoint: 指示器默认指向的元素的类名或序号
		*/
		//获取参数
		var wrap = options['wrap'],
			twrap = wrap.find(options['twrap']),
			iwrap = wrap.find(options['iwrap']),
			initPoint = options['initPoint'];

		//设置静态变量
		var indicator = iwrap.find('span'),
			indicatorWidth = twrap.children().width(),
			curLoc = 0,
			tarLoc = 0;

		//初始化
		function init(){
			if(typeof initPoint == 'number') {
				curLoc = twrap.children().eq(initPoint).position().left;
			} else if (typeof initPoint == 'string') {
				curLoc = twrap.find(initPoint).position().left;
			}
			tarLoc = curLoc;
			iwrap.css({width : twrap.width()});
			indicator.css({marginLeft: curLoc, width : indicatorWidth});
		}	
		init();
		//绑定事件
		twrap.children().on('mouseenter',function(){
			tarLoc = $(this).position().left;
			indicatorWidth = $(this).width();
			indicator.css({marginLeft: tarLoc, width: indicatorWidth});			
		}).on('mouseleave',function(){
			indicator.stop(true);	
		})
		twrap.on('mouseleave',function(){
			indicator.css({marginLeft: tarLoc, width: indicatorWidth});
		})
	}
	tabIndicator({wrap: $('.content-discount .tit'), twrap: 'ul', iwrap: '.indicator'});
	tabIndicator({wrap: $('.content-house .tit'), twrap: 'ul', iwrap: '.indicator'});
	tabIndicator({wrap: $('.content-sale-rent .tit'), twrap: 'ul', iwrap: '.indicator'});
	tabIndicator({wrap: $('.content-commerce .tit'), twrap: 'ul', iwrap: '.indicator'});


/*
	二手房分类导航特效
*/
	function accordion(options) {
		/*options
			wrap    : 包含所有分类的容器
			bwrap   : 分类的类名或标签
		*/
		var wrap = options['wrap'],
			bwrap = wrap.find(options['bwrap']),
			maxHeight = options['maxHeight'],
			minHeight = options['minHeight'];

		bwrap.on('mouseover',function(){
			bwrap.removeClass('act');
			$(this).addClass('act');

		});
	}
	accordion({wrap: $('.discount-l dl'), bwrap: '.discount-type', maxHeight: 129, minHeight: 81});
	accordion({wrap: $('.commerce-l dl'), bwrap: '.commerce-type', maxHeight: 129, minHeight: 81});
	accordion({wrap: $('.sale-rent-l dl'), bwrap: '.sale-rent-type', maxHeight: 129, minHeight: 81});


/*
	隐藏幻灯片按钮--首页新闻右上角幻灯，底部图片摄
*/
	$('.flash.jqDuang').on('mouseover',function(){
		$(this).find('.prev, .next').fadeIn().css('display','block');
	}).on('mouseleave',function(){
		$(this).find('.prev, .next').fadeOut();
	});

	$('.picture-flash.jqDuang').on('mouseover',function(){
		$(this).find('.prev, .next').fadeIn().css('display','block');
	}).on('mouseleave',function(){
		$(this).find('.prev, .next').fadeOut();
	});


});