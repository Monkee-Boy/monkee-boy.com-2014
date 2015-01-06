(function($) {

  // breakpoint vars
  var large_break = 980,
      medium_break = 840,
      small_break = 580;

  // debounce fn from david walsh
  // http://davidwalsh.name/javascript-debounce-function
  function debounce(func, wait, immediate) {
  	var timeout;
  	return function() {
  		var context = this, args = arguments;
  		var later = function() {
  			timeout = null;
  			if (!immediate) func.apply(context, args);
  		};
  		var callNow = immediate && !timeout;
  		clearTimeout(timeout);
  		timeout = setTimeout(later, wait);
  		if (callNow) func.apply(context, args);
  	};
  }


  // menu
  if(Modernizr.touch) {
    // dropdowns open on tap
    $('.main-nav').on('focus, click', '.has-dropdown > a', function(e) {
      e.preventDefault();

      $(this).parent('li').toggleClass('active');
    }).on('mouseout', function() {
      $(this).parent('li').removeClass('active');
    });
  } else {
    // sticky menu
    var lastScrollTop   = 0,
        banner          = $('[role="banner"]'),
        mainNav         = banner.find('.main-nav');

    var updateSticky = debounce(function() {
      var st = $(this).scrollTop();
      if ( st > lastScrollTop ) {
        // if scrolling down, no sticky
        if (mainNav.hasClass('sticky')) {
          mainNav.slideUp(150, function() {
            mainNav.removeClass('sticky').show();
          });
        }
      } else {
        if ( st > (banner.offset().top + banner.outerHeight()) ) {
          // if it doesn't already have the sticky class, and it's moved enough down
          if ( !mainNav.hasClass('sticky') && lastScrollTop - st > 10 ) {
            mainNav.hide().addClass('sticky').slideDown();
          }
        } else {
          // remove sticky class if back at the top of the page
          mainNav.removeClass('sticky');
        }
      }
      lastScrollTop = st;
    }, 10);
    window.addEventListener('scroll', updateSticky);
  }

  $('.mobile-menu').on('click', '.has-dropdown > a', function(e) {
    e.preventDefault();

    var $this = $(this);

    if ($this.parent('li').hasClass('active')) {
      $this.parent('li').removeClass('active');
      close_mobile_accordion($this.siblings('ul'));
    } else {
      close_mobile_accordion($mobile_menu.find('.has-dropdown.active ul'));
      $mobile_menu.find('.has-dropdown').removeClass('active');
      $this.parent('li').addClass('active');
      open_mobile_accordion($this.siblings('ul'));
    }
  });

  // move menu to mobile menu for tablet & down
  if ( Modernizr.mq('only screen and (max-width:' + medium_break + 'px)') ) {
    console.log("medium screen or down");
    // add main nav to mobile menu
    var $mobile_menu = $('.mobile-menu'),
        $main_nav = $('.main-menu').children('li');

    $mobile_menu.append($main_nav);

    $('.mobile-menu-trigger').on('click', function(e) {
      e.preventDefault();
      if ( $(this).hasClass('active') ) {
        $(this).removeClass('active');
        close_mobile_menu();
      } else {
        $(this).addClass('active');
        open_mobile_menu();
      }
    });
  }

  // mobile menu fn's
  function open_mobile_menu() {
    $('body').addClass('menu-open');

    var $container = $('.container'),
        $menu_items = $('.mobile-menu').children('li');

    // set up li's to be off screen
    TweenLite.set($menu_items, {
      x: 250,
      opacity: 0.5
    });

    // animate container to the left
    TweenLite.to($container, 0.3, {
      x: -250,
      ease: Power3.easeOut
    });

    // stagger animation of menu items
    for (var i = 0; i < $menu_items.length; i++) {
      TweenLite.to($menu_items[i], 0.2, {
        x: 0,
        opacity: 1,
        delay: 0.075*i + 0.05
      });
    }
  }

  function close_mobile_menu() {
    $('body').removeClass('menu-open');
    TweenLite.to($('.container'), 0.3, {
      x: 0,
      ease: Power3.easeOut
    });
  }

  function open_mobile_accordion(ul) {
    var $menu_items = ul.children('li'),
        height = $menu_items.length * 31 + 8;

    TweenLite.set($menu_items, {
      x: 150,
      opacity: 0.5
    });

    TweenLite.to(ul, 0.25, {
      height: height,
      ease: Power3.easeOut
    });

    for (var i = 0; i < $menu_items.length; i++) {
      TweenLite.to($menu_items[i], 0.2, {
        x: 0,
        opacity: 1,
        delay: 0.06*i + 0.025
      });
    }
  }

  function close_mobile_accordion(ul) {
    TweenLite.to(ul, 0.25, {
      height: 0,
      ease: Power3.easeOut
    });
  }

  // forms
  $('.input-wrapper').on('focus', 'input, textarea', function() {
    $(this).parent('.input-wrapper').addClass('focused');
  }).on('blur', 'input, textarea', function() {
    $(this).parent('.input-wrapper').removeClass('focused');
  });

  $('.select-box').on('change', 'select', function(e) {
    if (this.value) {
      $(this).parent('.select-box').addClass('selected');
    } else {
      $(this).parent('.select-box').removeClass('selected');
    }
  });

  $('.date-input input').datepicker({
    autoclose: true,
    format: "mm/dd/yyyy"
  }).on('changeDate', function() {
    $(this).parent().addClass('selected');
  });

  $('.input-switch').on('change', function() {
    var switch_id = $(this).data('switchto'),
        $targets = $(this).parents('.row').find('.switch-target');

    $targets.removeClass('active').filter('#' + switch_id).addClass('active');
  });

  // file upload
  var brief_uploader = new plupload.Uploader({
    runtimes : 'html5,flash,silverlight,html4',

    browse_button : $('.add-files')[0],
    container: $('.uploaded-files')[0],
    drop_element: $('.upload-box')[0],

    url : "/examples/upload",

    filters : {
        max_file_size : '50mb',
        mime_types: [
            {title : "Image files", extensions : "jpg,gif,png"},
            {title : "Zip files", extensions : "zip"}
        ]
    },

    // Flash settings
    flash_swf_url : '/bower_components/plupload/js/Moxie.swf',

    // Silverlight settings
    silverlight_xap_url : '/bower_components/plupload/js/Moxie.xap',


    init: {
        PostInit: function() {
          //document.getElementById('filelist').innerHTML = '';

          // drag/drop highlighting
          if(brief_uploader.runtime === 'html5') {
            $('.upload-box, .upload-box div').on('dragenter', function() {
                $('.upload-box').addClass('incoming');
            });

            $('.upload-box, .upload-box div').on('dragleave drop', function() {
                $('.upload-box').removeClass('incoming');
            });
          }
        },

        FilesAdded: function(up, files) {
          if ($('.upload-box').hasClass('initial')) {
            $('.upload-box').removeClass('initial');
            $('.add-files').html('select more files');
          }
          plupload.each(files, function(file) {
            $('.uploaded-files').append('<div id="' + file.id + '"><span class="name">' + file.name + ' (' + plupload.formatSize(file.size) + ')</span><span class="bg"></span></div>');
          });
          brief_uploader.start();
        },

        UploadProgress: function(up, file) {
          console.log("percent complete:", file.percent);
        },

        Error: function(up, err) {
          console.log("error:", err.code, err.message);
        }
    }
  });

  brief_uploader.init();

  // monkee quote form
  if ($('.request-quote-form').length > 0) {

    // attach validation
    $('.request-quote-form').validationEngine('attach', {
      showArrow: false,
      binded: false,
      promptPosition: "bottomLeft",
      'custom_error_messages' : {
        'required': { 'message': 'Oops, looks like you forgot to add this field' },
        '#url' : {
          'custom[url]': { 'message': 'That doesn\'t look like the URLs we\'re used to.' }
        }
      }
    });

    // on blur, validate and set opacity
    $('.request-quote-form').on('blur', '.form-part1 input', function() {
      var $this = $(this),
          $steps = $('.request-quote-form').find('.monkee-step'),
          $monkee = $('.request-quote-form').find('.monkee'),
          is_valid = !$this.validationEngine('validate');

      // test if parent should be marked complete
      if (is_valid) {
        if ( $this.parent().is(':last-child') ) $this.parents('.form-step').addClass('complete');
      } else {
        $this.parents('.form-step').removeClass('complete');
      }

      // change opacity of monkee
      var complete_steps = $steps.filter('.complete').length;
      if (complete_steps > 0) {
        var opacity = 1 - complete_steps/$steps.length;
        $monkee.children('.dark-monkee').css('opacity', opacity);
        console.log("opacity should be", opacity);
      }
      // speech bubble
      if ( complete_steps === $steps.length ) {
        $monkee.addClass('speak');
      } else {
        $monkee.removeClass('speak');
      }
    });
  }

  var PortfolioSlider = function(el) {
    this.$el = $(el);
    this.$screenContainer = this.$el.find('.screens');
    this.$screens = this.$screenContainer.children('.screen');
    this.$thumbs = this.$el.find('.thumbs');
    this.ratios = {
      desktop: 0.727,
      tablet: 1.328,
      phone: 2.08
    };
    this.margin = 160;
    this.width = this.$screenContainer.width();
    this.thumbRatio = 0.2;
    this.activeSlide = 'desktop';
    this.siteName = this.$el.data('site');
  };

  PortfolioSlider.prototype._getX = function(pos, slide, ratio) {
    // get the x-translate value
    var abs_value = ( this.width - ($(slide).width() * ratio) ) / 2;
    if ( pos == 'left' ) {
      return -abs_value;
    } else {
      return abs_value;
    }
  };

  PortfolioSlider.prototype._moveSlide = function(el, pos, ratio) {
    var thumbRatio = ratio ? ratio : this.thumbRatio,
        scale = pos == 'active' ? 1 : thumbRatio,
        x = pos == 'active' ? 0 : this._getX(pos, el, thumbRatio);

    console.log("moving slide", el, "to position", pos);

    TweenLite.to(el, 0.5, {
      scale: scale,
      x: x
    });
  };

  PortfolioSlider.prototype.transitionSlides = function(direction) {
    // if it's the first transition, remove the class "initial"
    if ( this.$screenContainer.hasClass('initial') )
      this.$screenContainer.removeClass('initial');

    for (var key in this.$screens) {
      var el = this.$screens[key],
          curPos = el.hasClass('active')? 'active' : el.hasClass('right')? 'right' : 'left',
          nextPos;

      if ( (curPos == 'active' && direction == 'right') || (curPos == 'right' && direction == 'left') )
        nextPos = 'left';
      else if ( (curPos == 'left' && direction == 'right') || (curPos == 'active' && direction == 'left') )
        nextPos = 'right';
      else
        nextPos = 'active';

      // do z-index stuff
      if ( curPos == 'active' || nextPos == 'active' ) {
        el.css('z-index', 2);
      } else {
        el.css('z-index', 1);
      }

      this._moveSlide(el, nextPos);

      // add correct class
      el.removeClass(curPos).addClass(nextPos);
    }
  };

  PortfolioSlider.prototype.updateScreen = function(screenName) {
    for (var key in this.$screens) {
      var el = this.$screens[key].children('.screen-inner'),
          fileName = '/uploads/portfolio/'+key+'_image_'+screenName+'.png',
          // fileName = '/assets/port-' + this.siteName + '-' + key + '-' + screenName + '.png',
          image = document.createElement('img');

      image.src = fileName;
      el.html(image);
    }
  };

  PortfolioSlider.prototype.initFullSlider = function() {
    var containerWidth = this.width - this.margin*2,
        containerHeight = this.$screenContainer.height(),
        self = this,
        numScreens = 0;

    // we'll want to save screens by device type
    var screens = {};

    // set height, width, and position for all screens
    this.$screens.each(function() {
      var $this = $(this),
          type = $this.data('device');

      // horizontal tablet or phone
      if ($this.hasClass('horizontal')) {
        // inverse ratio
        self.ratios[type] = 1/self.ratios[type];
      }

      var height = self.ratios[type] > 1? containerHeight : containerWidth*self.ratios[type],
          width = self.ratios[type] < 1? containerWidth : containerHeight/self.ratios[type];

      $this.css({
        height: height + 'px',
        width: width + 'px',
        left: containerWidth/2 - width/2 + self.margin + 'px',
        top: containerHeight/2 - height/2 + 'px'
      });

      screens[type] = $this;
      numScreens++;

    });

    // save new screens object so we can access by device type
    this.$screens = screens;

    // do slider stuff if there are at least three screens
    console.log("there are this many screens:", numScreens);
    if ( numScreens > 2 ) {
      // set phone and tablet to be right and left
      self._moveSlide(this.$screens.phone, 'left', 0.6);
      self._moveSlide(this.$screens.tablet, 'right', 0.6);

      // add click event to portfolio nav
      $('.slider-nav').on('click', 'a', function(e) {
        e.preventDefault();

        if ( $(this).hasClass('port-left') ) {
          self.transitionSlides('left');
        } else {
          self.transitionSlides('right');
        }

        // remove scroll callout, if still present
        if (self.$screens.desktop.find('.scroll-msg').length > 0)
          self.$screens.desktop.find('.scroll-msg').remove();
      });
    }

  };

  PortfolioSlider.prototype.initMobileSlider = function() {
    var containerWidth = this.width,
        self = this;

    // we'll want to save screens by device type
    var screens = {};

    // set height, width, and position for all screens
    this.$screens.each(function() {
      var $this = $(this),
          type = $this.data('device'),
          height = null,
          width = null,
          left = 0,
          top = 0;

      // no tablet view on mobile
      if ( type == 'tablet' ) return true;

      // set mobile and desktop sizes
      if ( type == 'desktop' ) {
        width = containerWidth * 1.2;
        height = width * self.ratios[type];
        left = containerWidth * 0.2;
      } else if ( type == 'phone' ) {
        width = containerWidth * 0.4;
        height = width * self.ratios[type];
        top = height * 0.15;
        left = containerWidth * 0.05;
      }

      $this.css({
        height: height + 'px',
        width: width + 'px',
        left: left + 'px',
        top: top + 'px'
      });

      screens[type] = $this;

    });

    // save new screens object so we can access by device type
    this.$screens = screens;
  };

  PortfolioSlider.prototype.init = function() {
    var self = this;

    // init full slider if not mobile
    if ( Modernizr.mq('only screen and (min-width: ' + small_break + 'px)') ) {
      this.initFullSlider();
    } else {
      this.initMobileSlider();
    }

    this.$thumbs.find('.thumbnail:first').addClass('active');

    // add click event to portfolio thumbs
    this.$thumbs.on('click', '.thumbnail', function(e) {
      e.preventDefault();

      self.$thumbs.find('.thumbnail').removeClass('active');
      $(this).addClass('active');

      var screenName = $(this).data('screen');
      self.updateScreen(screenName);
    });

    // remove scroll callout on scroll if there is a scroll callout
    var $scroll_callout = this.$screenContainer.find('.scroll-msg');
    if ($scroll_callout.length > 0) {
      $scroll_callout.parent('.screen-inner').on('scroll', function() {
        $(this).children('.scroll-msg').remove();
        $(this).off('scroll');
      });
    }

  };

  if ( $('.port-slider').length > 0 ) {
    var port_slider = new PortfolioSlider('.port-slider');
    port_slider.init();
  }

  // slick sliders
  $('.quote-slider').slick({
    dots: true,
    arrows: false,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    slide: 'li'
  });

  $('.thumbs-slider').slick({
    dots: false,
    arrows: true,
    slidesToShow: 3,
    slidesToScroll: 3,
    infinite: false,
    swipeToSlide: true
  });

  $('.fullwidth-slider ul').slick({
    dots: false,
    arrows: true,
    slidesToShow: 1,
    slide: 'li',
    centerMode: true,
    centerPadding: '140px',
    onInit: function() {
      $('.slick-prev').detach().appendTo('.slick-active .slick-photo-wrapper');
      $('.slick-next').detach().appendTo('.slick-active .slick-photo-wrapper');
    },
    onAfterChange: function() {
      $('.slick-prev').detach().appendTo('.slick-active .slick-photo-wrapper');
      $('.slick-next').detach().appendTo('.slick-active .slick-photo-wrapper');
    },
    responsive: [{
      breakpoint: small_break,
      settings: {
        dots: false,
        arrows: false,
        infinite: true,
        slidesToShow: 1,
        slide: 'li',
        centerMode: true,
        centerPadding: '80px'
      }
    }]
  });

  // home page hero circles
  var HeroCircles = function(el) {
    this.$el = $(el);
    this.$circles = this.$el.find('.circle');
    this.$expander = this.$el.find('.circle-expander');
    this.$cur_circle = null;
  };

  HeroCircles.prototype._placeBG = function() {

    // get parent position and dimensions
    var self = this,
        parent_pos = this.$el.offset(),
        parent_width = this.$el.width(),
        parent_height = this.$el.height();

    this.$circles.each(function() {
      var $circle = $(this),
          offset = $circle.offset(),
          $bg = $circle.children('.bg');

      // set position
      $bg.css({
        'top': parent_pos.top - offset.top + 'px',
        'left': parent_pos.left - offset.left + 'px',
        'width': parent_width + 'px',
        'height': parent_height + 'px'
      });
    });

  };

  HeroCircles.prototype._animateInTitle = function(delay) {
    var self = this,
        $title = this.$expander.children('.title-overlay'),
        cur_class = this.$cur_circle.data('name'),
        $expander_nav = this.$expander.children('.expander-nav').children('a').not('.' + cur_class);

    TweenLite.set($expander_nav.last(), { x: 160, right: 4,  left: 'auto', delay: delay });
    TweenLite.set($expander_nav.first(), {
      x: -160,
      left: 4,
      right: 'auto',
      delay: delay,
      onComplete: function() {
        // add content to title overlay after delay
        $title.html(self.$cur_circle.siblings('.tagline').html());
      }
    });

    // animate in title overlay
    TweenLite.to($title, 0.5, {
      y: 40,
      delay: delay,
      ease: Back.easeOut
    });

    TweenLite.to($expander_nav, 0.15, {
      x: 0,
      delay: delay + 0.5
    });
  };

  HeroCircles.prototype._animateOutTitle = function() {
    var $title = this.$expander.children('.title-overlay'),
        cur_class = this.$cur_circle.data('name'),
        $expander_nav = this.$expander.children('.expander-nav').children('a').not('.' + cur_class);

    // animate out title overlay
    TweenLite.to($title, 0.5, {
      y: $title.outerHeight()
    });

    // animate out circles
    TweenLite.to($expander_nav.first(), 0.15, {
      x: -160
    });
    TweenLite.to($expander_nav.last(), 0.15, {
      x: 160
    });
  };

  HeroCircles.prototype._animateIn = function(circle) {
    var $circle = $(circle),
        $border = $circle.siblings('.border'),
        img = $circle.children('.bg').data('bg');

    // set current circle
    this.$cur_circle = $circle;

    // set bg image for expander div
    this.$expander.css('z-index', 4);
    this.$expander.children('.bg').css('background-image', 'url(' + img + ')');

    // add active class to li
    $circle.parent('li').addClass('active');

    // expand circle
    TweenLite.to($border, 0.3, {
      scale: 7
    });

    // fade in expander
    TweenLite.to(this.$expander, 0.5, {
      opacity: 1,
      delay: 0.5,
      onComplete: function() {
        TweenLite.set($border, { scale: 1 });
      }
    });

    // animate in title overlay
    this._animateInTitle(1);
  };

  HeroCircles.prototype._animateOut = function() {
    var self = this;

    // remove active class and scale down border
    this.$el.find('li').removeClass('active');

    // animate out title
    this._animateOutTitle();

    // fade out expander
    TweenLite.to(this.$expander, 0.5, {
      opacity: 0,
      delay: 0.5,
      onComplete: function() {
        self.$expander.css({
          'z-index': -1
        });
      }
    });

  };

  HeroCircles.prototype._animateSwitch = function(circle) {
    this._animateOutTitle();

    this.$cur_circle = $(circle);

    var img = this.$cur_circle.children('.bg').data('bg'),
        $bg = this.$expander.children('.bg');

    // switch active class
    this.$el.find('li').removeClass('active');
    this.$cur_circle.parent('li').addClass('active');

    TweenLite.to($bg, 0.3, {
      opacity: 0,
      delay: 0.5,
      onComplete: function() {
        $bg.css('background-image', 'url(' + img + ')');
        TweenLite.to($bg, 0.3, { opacity: 1 });
      }
    });

    this._animateInTitle(1);
  };

  HeroCircles.prototype.init = function() {
    var self = this;

    this._placeBG();

    // add click events
    this.$el.on('click', '.circle', function() {
      self._animateIn(this);
    });
    this.$el.find('.close-btn').on('click', function(e) {
      e.preventDefault();
      self._animateOut();
    });
    this.$expander.children('.expander-nav').on('click', 'a', function(e) {
      e.preventDefault();
      var new_class = $(this).attr('class'),
          $circle = self.$el.find('ul .' + new_class);

      console.log("new class is", new_class, "new circle is", $circle[0]);
      self._animateSwitch($circle);
    });
  };

  HeroCircles.prototype.initMobile = function() {
    var self = this,
        $mobile_slider = this.$el.find('.mobile-slider');

    this.$el.on('click', '.circle', function() {
      var $this = $(this),
          bg = $this.children('.bg').data('bg');

      self.$circles.removeClass('active');
      $this.addClass('active');

      $mobile_slider.html('<div>' + $this.siblings('.tagline').html() + '</div>');
      $mobile_slider.css('background-image', 'url(' + bg + ')');
    });

    this.$circles.first().trigger('click');
  };

  var hero_circles = new HeroCircles('.hero-circles');
  if ( Modernizr.mq('only screen and (min-width: ' + small_break + 'px)') ) {
    hero_circles.init();
  } else {
    hero_circles.initMobile();
  }

  // troop dropdowns
  $('.troop-list').on('click', '.trigger', function(e) {
    e.preventDefault();

    var $this = $(this),
        $li = $this.parent(),
        $troop_list = $this.parents('.troop-list'),
        $dropdown = $this.siblings('.profile-content');

    // if closing the accordion, change classes and be done
    if ($li.hasClass('active')) {
      $li.removeClass('active');
      $troop_list.children('li').removeClass('inactive');
      return;
    }

    $troop_list.children('li').not($li).removeClass('active').addClass('inactive');
    $li.removeClass('inactive').addClass('active');

    // set dropdown top to correct value
    var offset_top = $li.position().top + $li.outerHeight();
    $dropdown.css('top', offset_top + 'px');

  });

  // accordions
  var $accordions = $('.accordion');
  if ($accordions.length > 0) {
    $accordions.each(function() {
      var $this = $(this),
          height = $this.children('.content').outerHeight();
      $this.data('content-height', height);
      $this.children('.content').css('height', 0);
    });

    $accordions.on('click', '.trigger', function(e) {
      e.preventDefault();

      var $accordion = $(this).parent('.accordion'),
          $content = $accordion.children('.content'),
          height = $accordion.data('content-height');

      if ($accordion.hasClass('open')){
        $accordion.removeClass('open');
        height = 0;
      } else {
        $accordion.addClass('open');
      }

      TweenLite.to($content, 0.5, {
        height: height,
        ease: Power3.easeOut
      });

    });
  }

  /**************************************
  ** Header Blur on Scroll
  **************************************/

  function BlurHeader(el) {
    this.$el = $(el);
  }

  BlurHeader.prototype.blurImage = function() {
    console.log("blur image");
    this.$image = this.$el.find('.image-bg');
    var self = this;

    this.$image.on('load', function() {

      // position and size image in center
      var containerWidth = self.$el.outerWidth(),
          containerHeight = self.$el.outerHeight(),
          imageWidth = self.$image.width(),
          imageHeight = self.$image.height(),
          width = 0,
          height = 0,
          offsetLeft = 0,
          offsetTop = 0;
      if ( imageWidth/imageHeight > containerWidth/containerHeight ) {
        width = containerHeight * (imageWidth/imageHeight);
        height = containerHeight;
        offsetLeft = -(width - containerWidth)/2;
      } else {
        width = containerWidth;
        height = containerWidth * (imageHeight/imageWidth);
        offsetTop = -(height-containerHeight)/2;
      }

      self.$image.css({
        'width': width + 'px',
        'height': height + 'px',
        'left': offsetLeft + 'px',
        'top': offsetTop + 'px',
        'display': 'block'
      });

      if ( Modernizr.canvas && !Modernizr.touch ) {
        // create and append canvas
        var canvas = document.createElement('canvas');
        canvas.width = width;
        canvas.height = height;
        canvas.style.left = offsetLeft + 'px';
        canvas.style.top = offsetTop + 'px';
        self.$el.append(canvas);

        // set up blurry canvas
        var $window = $(window),
            transitionBlur = new TweenLite.to(canvas, 1, {opacity: 1, paused: true});

        var blurScroll = function() {
          var pos = $window.scrollTop(),
              progress = ( 1/(self.$el.height() - 80) ) * pos;

          // set tween to current progress
          if(progress >= 0 && progress <= 1) {
            transitionBlur.progress(progress);
          }
        };

        stackBlurImage( self.$image[0], canvas, 40, false );
        $window.on('scroll', blurScroll);
      }
    }).each(function() {
      // catch cached images -- seems to be causing it to run twice right now
      //if(this.complete) $(this).load();
    });
  };

  if ($('.blur-image').length > 0 ) {
    var page_header = new BlurHeader('.blur-image');
    page_header.blurImage();
  }

  // contact page map
  if ($('#contact-map').length > 0) {
    var map_styles = [{
        featureType:'landscape',
        elementType:'all',
        stylers:[
          { color:'#dbf1ee' },
          { visibility:'on' }
        ]
      }, {
        featureType:'water',
        elementType:'geometry.fill',
        stylers:[
          { color:'#b4d7e6' },
          { visibility:'on' }
        ]
      }, {
        featureType:'road.highway',
        elementType:'geometry.fill',
        stylers:[
          { color:'#69bfb2' },
          { visibility:'on' }
        ]
      }, {
        featureType:'road.highway',
        elementType:'geometry.stroke',
        stylers:[
          { color:'#ffffff' },
          { visibility:'on' }
        ]
      }, {
        featureType:'road.arterial',
        elementType:'all',
        stylers:[
          { color:'#ffffff' },
          { visibility:'simplified' }
        ]
      }, {
        featureType:'poi.park',
        elementType:'geometry.fill',
        stylers:[
          { color:'#bcca7f' },
          { visibility:'on' }
        ]
      }, {
        featureType:'road.local',
        elementType:'all',
        stylers:[
          { color:'#d6ebe8' },
          { visibility:'off' }
        ]
      }, {
        featureType:'poi.attraction',
        elementType:'geometry.fill',
        stylers:[
          { color:'#cce5e1' },
          { visibility:'on' }
        ]
      }, {
        featureType:'poi.place_of_worship',
        elementType:'geometry.fill',
        stylers:[
          { color:'#cce5e1' },
          { visibility:'on' }
        ]
      }, {
        featureType:'poi.government',
        elementType:'geometry.fill',
        stylers:[
          { color:'#cce5e1' },
          { visibility:'on' }
        ]
      }, {
        featureType:'poi.school',
        elementType:'geometry.fill',
        stylers:[
          { color:'#cce5e1' },
          { visibility:'on' }
        ]
      }, {
        featureType:'poi.business',
        elementType:'geometry.fill',
        stylers:[
          { color:'#bcd7d2' },
          { visibility:'on' }
        ]
      }, {
        featureType:'poi.medical',
        elementType:'geometry',
        stylers:[
          { color:'#e5fbf8' },
          { visibility:'off' }
        ]
      }, {
        featureType:'road',
        elementType:'labels',
        stylers:[
          { hue:'#ffffff' },
          { saturation:-100 },
          { lightness:100 },
          { visibility:'off' }
        ]
      }, {
        featureType:'transit',
        elementType:'labels',
        stylers:[
          { hue:'#ffffff' },
          { saturation:0 },
          { lightness:100 },
          { visibility:'off' }
        ]
      }, {
        featureType:'landscape.man_made',
        elementType:'geometry',
        stylers:[
          { color:'#e6faf8' },
          { visibility:'off' }
        ]
      }, {
        featureType:'administrative.neighborhood',
        elementType:'labels.text.fill',
        stylers:[
          { color:'#42454c' },
          { visibility:'on' }
        ]
      }, {
        featureType:'road.local',
        elementType:'all',
        stylers:[
          { color:'#cbe7e3' },
          { visibility:'simplified' }
        ]
      }
    ];
    var office_loc = new google.maps.LatLng(30.383294, -97.743659),
        marker_image = '/images/map-marker.png';
    var map = new google.maps.Map(document.getElementById('contact-map'), {
      zoom: 14,
      center: office_loc,
      'styles': map_styles,
      scrollwheel: false
    });

    var office_marker = new google.maps.Marker({
      map: map,
      animation: google.maps.Animation.DROP,
      position: office_loc,
      icon: marker_image
    });
    office_marker.setMap(map);
  }

  // shoot bananas from the footer
  function shoot_bananas() {
    console.log("shooting bananas");
    var a = 0.8, // vertical accelleration
        num_bananas = Math.ceil(Math.random() * 4 + 1),
        pos = [0, -20],
        $banana_triangle = $('.bananas');


    // create some bananas and shoot them
    for (var i = 0; i < num_bananas; i++) {
      var banana = $('<div class="shooting-banana" />'),
          vx = (0.5 - Math.random()) * 10, // horizontal velocity, can be positive or negative
          vy = -Math.random() * 20; // initial vertical velocity

      console.log("initial x velocity:", vx + ", initial y velocity:", vy);
      $banana_triangle.append(banana);
      update_banana_pos(banana, pos, vx, vy, a);
    }
  }

  if (!Modernizr.touch) {
    $('.bananas').on('mouseenter', shoot_bananas);
  }
  $('.back-to-top').on('click', function(e) {
    e.preventDefault();
    window.scrollTo(0,0);
  });

  function update_banana_pos(banana, p0, vx, vy, a) {
    // we're under the assumption that 1 time unit has passed each iteration
    var posX = p0[0] + vx,
        posY = p0[1] + vy,
        transform = 'matrix(1, 0, 0, 1, '+ posX + ', '+ posY +')';

    // update velocity
    vy += a;

    // set the transform
    banana[0].style.webkitTransform = transform;
    banana[0].style.MozTransform = transform;
    banana[0].style.msTransform = transform;
    banana[0].style.OTransform = transform;
    banana[0].style.transform = transform;

    // if posX is greater than 20px below, keep going
    if ( posY < 20) {
      requestAnimationFrame(function() {
        update_banana_pos(banana, [posX, posY], vx, vy, a);
      });
    } else {
      banana.remove();
    }
  }

  $('.news-load-more').on('click', function(e) {
    e.preventDefault();

    $.getJSON('/latest-news-ajax/?page='+(news_current_page + 1), function(data) {
      $.each(data.articles, function(key, article) {
        block = $('.news-item').last().parent().clone();

        block.find('.date').html( article.publish_on_month+'.'+article.publish_on_day+'<span>'+article.publish_on_year+'</span>' );
        block.find('a').attr('href', article.url).attr('title', article.titlel).html(article.title);

        $('.news-item').last().parent().after(block);
      });

      if((news_current_page + 1) === news_total_pages) {
        $('.news-load-more').hide();
      } else {
        news_current_page++;
      }
    });
  });

  $('.form-newsletter form').on('submit', function(e) {
    e.preventDefault();

    $.getJSON('/mailchimp-subscribe/?email='+encodeURIComponent($('.form-newsletter input[name=email]').val()),function(data){
      if(data.status === 'passed') {
        $('.form-newsletter .subscribe-status').addClass('success');
      } else {
        $('.form-newsletter .subscribe-error').show();
      }
    });

    return false;
  });

}(jQuery));
