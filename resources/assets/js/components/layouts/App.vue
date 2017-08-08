<template>
  <div>
    <!-- =========================

    Header Section

    ============================== -->
    <page-header></page-header>

    <!-- =========================

       Navigation Section

    ============================== -->
    <page-navigation></page-navigation>

    <!-- =========================

        Component Details

    ============================== -->
    <section class="component">
      <slot name="section"></slot>
    </section>

    <!-- =========================

    Footer

    ============================== -->
    <page-footer></page-footer>
  </div>
</template>
