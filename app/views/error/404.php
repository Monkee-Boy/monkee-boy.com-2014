<?php $this->tplDisplay('inc_header.php', ['menu'=>'404','sPageTitle'=>'Page Not Found']); ?>

  <div class="row">
    <div class="page-title">
      <h1>You Done 404'd</h1>
      <p class="subtitle">What the fuck did you even do???</p>
    </div>
  </div>

  <div class="row">
    <div class="single-column column-404">
      <p><strong>Error 404</strong>: The page you're looking for has been moved or no longer exists. You can start back at our <a href="/" title="Home Page">home page</a> or <a href="/search/" title="Search Site">search</a> for the page your looking for.</p>
      <div id="flowchart404">
        <a href="/contact/work-with-us" class="button get-started">Let's get started!</a>
        <a href="/blog" class="button button-alt col1 blog">Check out our blog!</a>
        <a href="http://www.austinpetsalive.org/adopt/dogs/" class="button col1 puppy">Yes Please!</a>
        <a href="/our-process" class="button button-alt2 process">Check out our process!</a>
        <a href="/the-work" class="button work">Check out our work!</a>
        <a href="http://www.austinpetsalive.org/adopt/cats/" class="button button-alt cats">I like cats better!</a>
        <a href="/blog/freebie-friday" class="button button-alt2 col4 images">Images!</a>
        <a href="/blog/latest-post" class="button button-alt col4 info">Information!</a>
        <a href="https://www.youtube.com/watch?v=g2D-7o2IBCI" class="button button-alt2 col3 hiphop">Hip Hop!</a>
        <a href="https://www.youtube.com/watch?v=pls_luhVdAw" class="button button-alt col3 pop">Pop!</a>
        <a href="https://www.youtube.com/watch?v=XycBLF6kWuY" class="button col3 rock">Rock!</a>
        <a href="https://www.youtube.com/watch?v=owtHJ4adc70" class="button button-alt2 col3 puppies">Puppies!</a>
      </div>
    </div>
  </div>

<?php $this->tplDisplay('inc_footer.php'); ?>
