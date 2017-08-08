<template>
  <footer class="footer" id="footer_section">
    <div class="container">
      <div class="col-md-3 col-sm-12 footer-logo">
        <img src="images/footer_logo.png" alt="Footer Logo">
      </div>
      <div class="col-md-9 col-sm-12 copy-right">
        <p>&copy; {{ this.$moment().year() }} Cajun Operating Company, under license by Cajun Funding Corp. All rights reserved</p>
      </div>
    </div><!-- end .containter -->
  </footer>
</template>

<script>
    export default {
        name: 'FooterVue'
    }
</script>
