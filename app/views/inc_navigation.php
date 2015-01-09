<header role="banner">
  <div class="top-bar">
    <div class="row-flush">
      <ul class="super-nav full">
        <li><a href="/work-with-us/" title="Request A Quote">Request A Quote &raquo;</a></li>
      </ul>
    </div> <!-- /.row -->
  </div> <!-- /.top-bar -->

  <div class="sticky-nav-wrapper">
    <nav class="main-nav" role="navigation">
      <div class="row-flush">
        <div class="full">
          <div class="logo">
            <img src="/images/monkee-speak.png" alt="I'll Take You Home" class="speak">
            <a href="/">Monkee-Boy Web Design</a>
          </div>

          <ul class="main-menu">
            <li class="primary has-dropdown">
              <a href="/who/why-monkee-boy/" class="nav-who<?php if($current==='who'): ?> current<?php endif; ?>">Who We Are</a>
              <?php $this->tplDisplay('subnav/who.php', array('menu'=>$menu,'from'=>'nav')); ?>
            </li>
            <li class="primary has-dropdown">
              <a href="/our-process/" title="" class="nav-what<?php if($current==='what'): ?> current<?php endif; ?>">What We Do</a>
              <?php $this->tplDisplay('subnav/what.php', array('menu'=>$menu,'from'=>'nav')); ?>
            </li>
            <li class="primary has-dropdown">
              <a href="/the-work/" title="" class="nav-work<?php if($current==='work'): ?> current<?php endif; ?>">The Work</a>
              <?php $this->tplDisplay('subnav/work.php', array('menu'=>$menu,'from'=>'nav')); ?>
            </li>
            <li class="primary has-dropdown">
              <a href="/contact/" title="" class="nav-contact<?php if($current==='contact'): ?> current<?php endif; ?>">Contact</a>
              <?php $this->tplDisplay('subnav/contact.php', array('menu'=>$menu,'from'=>'nav')); ?>
            </li>
            <li class="primary"><a href="/blog/" title="" class="nav-blog">The Blog</a></li>
          </ul>

          <a href="/contact/work-with-us/" title="Request A Quote" class="request-quote">Request A<span>Quote &raquo;</span></a>
        </div>
      </div> <!-- /.row -->
    </nav>
  </div>

  <div class="mobile-header">
    <a href="/" title="Monkee-Boy Web Design" class="mobile-logo">Monkee-Boy Web Design</a>
    <a href="#" class="mobile-menu-trigger">Menu</a>
  </div>
</header>
