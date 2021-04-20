<template>
  <!-- //banner two -->
  <div class="banner-two">
      <div class="container">
        <div class="group-banners" v-for="language in languages">
          <h3 class="box-title">Choose / Set Slider Images for the "{{language.name}}"</h3>
            <div class="row">
              <div class="col-12 col-md-8">
                <figure style="margin-bottom:34px;"class="banner-image" v-for="slider in language.sliders">
                  <a><img data-toggle="modal" data-target="#bannerModal"  @click="updateSliderId(slider.sliders_id,slider.carousel_id)"  class="img-fluid"v-bind:src="'/'+slider.path" alt="Banner Image"></a>
                </figure>
              </div>


            </div>
        </div>
      </div>
      <div class="modal fade" id="bannerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                      <h3 class="modal-title text-primary" id="myModalLabel">Choose Slider </h3>
                  </div>
                  <div class="modal-body manufacturer-image-embed">
                    <img data-dismiss="modal" style="width:120px; height:120px; margin:5px;border:1px solid lightgrey" v-for="image in images" @click="update(image.id)"  class="img-fluid"v-bind:src="'/'+image.path" alt="Banner Image">
                    <div class="modal-footer">
                  </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

</template>

<script>
    export default {
      components: {
        },
        props: [
          'data'
        ],
        data() {
          return {
                languages : this.data.languages,
                images : this.data.images,
                slider_id : '',
                carousel_id: '',
                language_id : '',
                url:''
          }
        },

        methods: {
          updateSliderId(id,carousel_id){
            this.slider_id = id;
            this.carousel_id = carousel_id;
          },
           update(image_id){
             axios.post('updateslider', {
                    slider_id: this.slider_id,
                    image_id: image_id,
                    url:this.url,
                    carousel_id: this.carousel_id
                  })
                  .then(response => {
                    if(response.status===200){
                      this.languages = response.data;
                    }
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
           }

        },
        created(){

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
