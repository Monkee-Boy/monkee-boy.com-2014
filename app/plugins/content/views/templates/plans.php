<!--
@Name: Plans
@Description: Showcase of all typography and content blocks.
@Version: 1.0
@Restricted: false
@Author: Monkee-Boy
-->

<?php $this->tplDisplay("inc_header.php", ['menu'=>'home']); ?>

  <div class="row page-title">
    <h1><?php echo $aContent['title'] ?></h1>
    <span class="subtitle"><?php echo $aContent['subtitle'] ?></span>
  </div>

    <?php $this->tplDisplay('inc_subnav.php', array('menu' => 'how', 'nav' => 'plan-options')); ?>

  <div class="row">
    <div class="single-column content-block">
      <?php echo $aContent['content'] ?>
    </div>
  </div>

  <div class="row">
    <div class="plan-features">
      <h3>Social Media Basic Features</h3>
      <div class="row-flush">
        <ul class="list-style-alt">
          <li>site audit</li>
          <li>new social images</li>
          <li>fix broken links</li>
          <li>lorem ipsum</li>
          <li>site audit</li>
          <li>new social images</li>
          <li>fix broken links</li>
          <li>lorem ipsum</li>
          <li>site audit</li>
          <li>new social images</li>
          <li>fix broken links</li>
          <li>lorem ipsum</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="row flush-later">
    <div class="box-of-doom meet-the-team full-width">
      <div class="meet-the-team-content">
        <h3>Who is on my monkee-boy team?</h3>
        <p>Curabitur sodales massa nec orci bibendum, ut luctus odio consequat. Aenean sodales facilisis orci, in vulputate magna blandit eu. Curabitur quis orci quis nibh commodo elementum faucibus nec dolor. Integer ut felis ipsum. Vestibulum nibh ex, pretium et congue eget, sollicitudin ac libero. Aliquam aliquet laoreet mi, vel accumsan libero imperdiet id. In hac habitasse platea dictumst. Praesent eget lacus sodales, consequat orci ac, imperdiet ex. Sed rutrum consequat eros, ac vehicula orci laoreet sed.</p>
        <ul class="team-list">
          <li>Project Manager</li>
          <li>Content Strategist</li>
          <li>Creative Director</li>
          <li>UI/UX Designer</li>
          <li>Wordpress Developer</li>
          <li>Copywriter</li>
          <li>Maintenance Specialist</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="full no-gutter-later">
      <div class="plans">
        <div class="plan-row">
          Social Media Basic Cost: <span><sup>$</sup>555<sup class="cents">00</sup></span>
        </div>
        <div class="plan-row">
          <div class="row-flush">
            <div class="plan-row-left">
              <h4>Get In Touch</h4>
              <p>Curabitur sodales massa nec orci bibendum, ut luctus odio consequat. Aenean sodales facilisis orci, in vulputate magna blandit eu. Curabitur quis orci quis nibh commodo elementum faucibus nec dolor. Integer ut felis ipsum. Vestibulum nibh ex, pretium et congue eget, sollicitudin ac libero.</p>
            </div>
            <div class="plan-row-right">
              <a href="#" class="button">Call us!</a>
            </div>
          </div>
        </div>
        <div class="plan-row">
          <h4>Production Schedule</h4>
          <p>Curabitur sodales massa nec orci bibendum, ut luctus odio consequat. Aenean sodales facilisis orci, in vulputate magna blandit eu. Curabitur quis orci quis nibh commodo elementum faucibus nec dolor. Integer ut felis ipsum. Vestibulum nibh ex, pretium et congue eget, sollicitudin ac libero.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="plan-cta">
      <h2>Need a <span>different plan</span>?</h2>
      <p>That's ok - check out our other packages:</p>
      <ul class="list-style-alt">
        <li><a href="#">Social Media Plus</a>: Curabitur sodales massa nec orci bibendum, ut luctus odio consequat.</li>
        <li><a href="#">Social Media Custom</a>: Curabitur sodales massa nec orci bibendum, ut luctus odio consequat.</li>
      </ul>
    </div>
  </div>

<?php $this->tplDisplay("inc_footer.php"); ?>
