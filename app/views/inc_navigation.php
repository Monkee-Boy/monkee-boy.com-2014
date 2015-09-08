<header role="banner">
  <div class="top-bar">
    <div class="row-flush">
      <ul class="super-nav full">
        <li><a href="/contact/request-a-quote/" title="Get Started With Monkee-Boy">Get Started &raquo;</a></li>
      </ul>
    </div> <!-- /.row -->
  </div> <!-- /.top-bar -->

  <nav class="main-nav" role="navigation">
    <div class="row-flush">
      <div class="full">
        <div class="logo">
          <img src="/images/monkee-speak.png" alt="I'll Take You Home" class="speak">
          <a href="/">Monkee-Boy Web Design</a>
        </div>

        <ul class="main-menu">
          <li class="primary has-dropdown">
            <a href="/who/our-expertise/" class="nav-who<?php if($current==='who'): ?> current<?php endif; ?>">Who We Are</a>
            <?php $this->tplDisplay('subnav/who.php', array('menu'=>$menu,'from'=>'nav')); ?>
          </li>
          <li class="primary has-dropdown">
            <a href="/how-we-help/web-design-and-development/" title="" class="nav-how<?php if($current==='how'): ?> current<?php endif; ?>">How We Help</a>
            <?php $this->tplDisplay('subnav/how.php', array('menu'=>$menu,'from'=>'nav')); ?>
          </li>
          <li class="primary has-dropdown">
            <a href="/the-work/" title="" class="nav-work<?php if($current==='work'): ?> current<?php endif; ?>">The Work</a>
            <?php $this->tplDisplay('subnav/work.php', array('menu'=>$menu,'from'=>'nav')); ?>
          </li>
          <li class="primary has-dropdown">
            <a href="/contact/request-a-quote/" title="" class="nav-contact<?php if($current==='contact'): ?> current<?php endif; ?>">Contact</a>
            <?php $this->tplDisplay('subnav/contact.php', array('menu'=>$menu,'from'=>'nav')); ?>
          </li>
          <li class="primary"><a href="/blog/" title="" class="nav-blog">The Blog</a></li>
        </ul>

        <a href="/contact/request-a-quote/" title="Get Started With Monkee-Boy" class="request-quote">Get <span>Started &raquo;</span></a>
      </div>
    </div> <!-- /.row -->
  </nav>

  <div class="mobile-header">
    <a href="/" title="Monkee-Boy Web Design" class="mobile-logo">Monkee-Boy Web Design</a>
    <a href="#" class="mobile-menu-trigger">Menu</a>
  </div>
</header>
