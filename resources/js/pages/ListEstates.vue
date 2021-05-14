<template>
	<main id="main">
	    <section class="section_propertyinformation">
	        <div class="container">
	            <div class="row">
                	<EstatesComponent></EstatesComponent>
	            </div>
	        </div>
	    </section>
    </main>
</template>

<script>
    export default {
    	components: {
            EstatesComponent: () => import('../components/EstatesComponent'),
        },
    };
</script>
