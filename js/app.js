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
  };

  PortfolioSlider.prototype.init = function() {
    var containerWidth = this.$screenContainer.width() - this.margin*2,
        containerHeight = this.$screenContainer.height(),
        self = this;

    console.log("container width", containerWidth, "container height", containerHeight);

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

      console.log("set screen", $this[0], 'width', width, 'height', height);

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
