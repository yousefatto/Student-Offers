</ul>
</section><!-- .buckets -->

</main>
<!-- .Footer -->
  <footer class="colophon">
      <aside> All rights reserved</aside>
      <aside> Study Portal &copy; <?php echo date('Y');?></aside>
      <aside>For suggestions & more information, <a href="<?php echo url_for('user/contact_us.php'); ?>" target="_blank" rel="nofollow">Contact us</a>.</aside>


      </aside>
  </footer>

</body>

</html>
<?php
    db_disconnect($db); 
?>
