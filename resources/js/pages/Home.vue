<template>
  <main id="main" class="antialiased">
    <section class="section_topbanner" style="background: url('/design/images/bg_top.jpg') no-repeat center center; background-size: cover;">
        <div class="container">
            <div class="row">

            </div>
        </div>
    </section>

    <section class="section_recommand">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <h2>LIST ESTATE</h2>
                        <EstatesTopComponent></EstatesTopComponent>
                    </div>
                    <div style="text-align: center; width: 100%;">
                    <button><a href="/list">List Esate Page</a></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </main>
</template>
<script>
    import EstatesTopComponent from '../components/EstatesTopComponent'
    export default {
        components: {
            EstatesTopComponent,
        },
    };
</script>
