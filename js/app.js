(function($) {

  // forms
  $('.input-wrapper input').on('focus', function() {
    $(this).parent('.input-wrapper').addClass('focused');
  }).on('blur', function() {
    $(this).parent('.input-wrapper').removeClass('focused');
  });

  // monkee quote form
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
  $('.request-quote-form').on('blur', '.form-part1 input', function() {
    var $this = $(this),
        $steps = $('.request-quote-form').find('.monkee-step'),
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
      $('.request-quote-form').find('.dark-monkee').css('opacity', opacity);
      console.log("opacity should be", opacity);
    }
  });

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
          fileName = '/assets/port-' + this.siteName + '-' + key + '-' + screenName + '.png',
          image = document.createElement('img');

      image.src = fileName;
      el.html(image);
    }
  };

  PortfolioSlider.prototype.init = function() {
    var containerWidth = this.width - this.margin*2,
        containerHeight = this.$screenContainer.height(),
        self = this;

    // we'll want to save screens by device type
    var screens = {};

    // set height, width, and position for all screens
    this.$screens.each(function() {
      var $this = $(this),
          type = $this.data('device'),
          height = self.ratios[type] > 1? containerHeight : containerWidth*self.ratios[type],
          width = self.ratios[type] < 1? containerWidth : containerHeight/self.ratios[type];

      $this.css({
        height: height + 'px',
        width: width + 'px',
        left: containerWidth/2 - width/2 + self.margin + 'px',
        top: containerHeight/2 - height/2 + 'px'
      });

      screens[type] = $this;

    });

    // save new screens object so we can access by device type
    this.$screens = screens;

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
    });

    // add click event to portfolio thumbs
    this.$thumbs.on('click', '.thumbnail', function(e) {
      e.preventDefault();

      self.$thumbs.find('.thumbnail').removeClass('active');
      $(this).addClass('active');

      var screenName = $(this).data('screen');
      self.updateScreen(screenName);
    });

  };

  if ( $('.port-slider').length > 0 ) {
    var port_slider = new PortfolioSlider('.port-slider');
    port_slider.init();
  }

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

    TweenLite.set($expander_nav.last(), { x: 160, right: 0,  left: 'auto', delay: delay });
    TweenLite.set($expander_nav.first(), {
      x: -160,
      left: 0,
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

  var hero_circles = new HeroCircles('.hero-circles');
  hero_circles.init();

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

}(jQuery));
