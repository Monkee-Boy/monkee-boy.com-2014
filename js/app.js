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

  var port_slider = new PortfolioSlider('.port-slider');
  port_slider.init();

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
