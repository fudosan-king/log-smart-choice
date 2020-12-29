<template>
	<main id="main">
	    <section class="section_searchresults bg_silver">
	        <div class="container">
	            <div class="row">
	                <div class="col-12 col-lg-12">
	                	<EstatesComponent></EstatesComponent>
	                </div>
	            </div>
	        </div>
	    </section>
    </main>
</template>

<script>
	import EstatesComponent from '../components/EstatesComponent'
    export default {
    	components: {
            EstatesComponent,
        },
    };
</script>
