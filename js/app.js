(function($) {

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
  };

  PortfolioSlider.prototype._getX = function(pos, slide, ratio) {
    // get the x-translate value
    var abs_value = ( this.width - ($(slide).width() * ratio) ) / 2;
    if ( pos == 'prev' ) {
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

    for (var key in this.$screens) {
      var el = this.$screens[key],
          curPos = el.hasClass('active')? 'active' : el.hasClass('next')? 'next' : 'prev',
          nextPos;

      if ( (curPos == 'active' && direction == 'next') || (curPos == 'prev' && direction == 'prev') )
        nextPos = 'next';
      else if ( (curPos == 'next' && direction == 'next') || (curPos == 'active' && direction == 'prev') )
        nextPos = 'prev';
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

  PortfolioSlider.prototype.init = function() {
    var containerWidth = this.width - this.margin*2,
        containerHeight = this.$screenContainer.height(),
        self = this;

    console.log("container width", containerWidth, "container height", containerHeight);

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
        left: containerWidth/2 - width/2 + self.margin + 'px'
      });

      screens[type] = $this;

      console.log("set screen", $this[0], 'width', width, 'height', height);

    });

    // save new screens object so we can access by device type
    this.$screens = screens;

    // set phone and tablet to be right and left
    self._moveSlide(this.$screens.phone, 'prev', 0.6);
    self._moveSlide(this.$screens.tablet, 'next', 0.6);

    // add click event to portfolio nav
    $('.slider-nav').on('click', 'a', function(e) {
      e.preventDefault();

      console.log("clicked slide nav");

      if ( $(this).hasClass('port-next') ) {
        console.log("transitioning to next slide");
        self.transitionSlides('next');
      } else {
        console.log("transitioning to prev slide");
        self.transitionSlides('prev');
      }
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
    this.$expander = $('<div class="circle-expander" />');
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

  HeroCircles.prototype._animateIn = function(circle) {
    var $circle = $(circle),
        $border = $circle.siblings('.border'),
        img = $circle.children('.bg').data('bg');
    // set bg image for expander div
    this.$expander.css({
      'background-image': 'url(' + img + ')',
      'z-index': 4
    });

    // add active class to li
    $circle.parent('li').addClass('active');

    TweenLite.to($border, 0.3, {
      scale: 7,
      //backgroundColor: '#000'
    });

    TweenLite.to(this.$expander, 0.5, {
      opacity: 1,
      delay: 0.5
    });
  };

  HeroCircles.prototype.init = function() {
    var self = this;

    this._placeBG();

    // add expander div
    this.$expander.append('<span />');
    this.$el.append(this.$expander);

    // add click event
    this.$el.on('click', '.circle', function() {
      self._animateIn(this);
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
