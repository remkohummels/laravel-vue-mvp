<template>
  <nav class="navbar navbar-default" id="navbar_section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>

          <div class="collapse navbar-collapse main-nav" id="navbar-collapse">
            <ul class="nav navbar-nav main-menu text-uppercase text-center">
              <router-link :to="{ name: 'dashboard' }" tag="li" active-class="active">
                <a>Home</a>
              </router-link>
              <router-link :to="{ name: 'product-mix' }" tag="li" active-class="active">
                <a v-bind:class="{ active: this.$store.state.productMixLinkActive }">Product Mix</a>
              </router-link>
              <router-link :to="{ name: 'sales-input' }" tag="li" active-class="active">
                <a v-bind:class="{ active: this.$store.state.salesInputLinkActive }">Sales Input</a>
              </router-link>
              <router-link :to="{ name: 'product-projection' }" tag="li" active-class="active">
                <a v-bind:class="{ active: this.$store.state.productProjectionLinkActive }">Product Projection</a>
              </router-link>
              <router-link :to="{ name: 'hours-operation' }" tag="li" active-class="active">
                <a>Hours of Operation</a>
              </router-link>
            </ul>
          </div>
        </div>
      </div>
    </div><!-- end conainer -->
  </nav>
</template>

<script>
    export default {
        name: 'NavigationVue'
    }
</script>
