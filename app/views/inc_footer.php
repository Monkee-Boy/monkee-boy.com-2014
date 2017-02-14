<?php
if(isset($aContent)) {
  if(!empty($aContent['cta_line1']) && !empty($aContent['cta_line2']) && !empty($aContent['cta_button'])) {
    $this->tplDisplay("inc_cta.php", array("line1"=>$aContent['cta_line1'], "line2"=>$aContent['cta_line2'], "button"=>$aContent['cta_button']));
  }
}
?>

  <footer role="contentinfo">
    <div class="row">
      <ul class="footer-social social-links">
        <li><a href="/blog/" title="Blog" class="blog">Blog</a></li>
        <li><a href="https://twitter.com/monkeeboy" title="Twitter" class="twitter">Twitter</a></li>
        <li><a href="https://www.facebook.com/monkeeboyweb" title="Facebook" class="facebook">Facebook</a></li>
        <li><a href="https://plus.google.com/+MonkeeBoyWebDesignIncAustin" title="Google Plus" class="gplus">Google Plus</a></li>
        <li><a href="http://instagram.com/monkeeboyweb" title="Instagram" class="instagram">Instagram</a></li>
        <li><a href="http://www.pinterest.com/monkeeboy/" title="Pinterest" class="pinterest">Pinterest</a></li>
      </ul>

      <div class="bananas">
        <a href="#" class="back-to-top"></a>
      </div>

      <p class="footer-meta"><strong>&copy; <?php echo date("Y"); ?> Monkee-Boy Web Design, Inc.</strong> // <a href="/contact/request-a-quote/" title="Request a Quote">Request a Quote!</a><br>
        <span class="address">9390 Research Blvd. Kaleido II Suite 425 Austin, TX  78759 // 512-335-2221</span></p>
    </div>
    <a href="#" class="mobile-home button">Back to Home</a>
  </footer>
  </div><!-- /.container -->

  <div class="mobile-menu-container">
    <ul class="mobile-menu">
      <li><a href="/contact/request-a-quote/" class="button">Request a Quote</a></li>
      <li><a href="tel:5123352221" class="button button-alt">Call Us</a></li>
      <li class="primary"><a href="/">Home</a></li>
    </ul>
  </div>

  <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
  <script>window.jQuery || document.write('<script src="/js/jquery.min.js"><\/script>')</script>
  <script src="/js/app<?php if(!$debug) { ?>.min<?php } ?>.js?v=2"></script>
</body>
</html>
