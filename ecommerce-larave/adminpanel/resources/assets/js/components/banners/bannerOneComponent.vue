<template>
<div class="container">
  <div class="group-banners" v-for="language in languages">
    <h3 class="box-title">Choose / Set Banner for the "{{language.name}}"</h3>
    <div class="row">
          <div class="col-sm-4" v-for="banner in language.banners" v-if="banner.type == 3 || banner.type == 4 || banner.type == 5">
            <figure class="banner-image ">
              <img  style="margin-left:-15px;"data-toggle="modal" data-target="#bannerModal"  @click="updateBannerId(banner.banners_id,banner.banners_title)"  class="img-fluid"v-bind:src="'/'+banner.path" alt="Banner Image">
            </figure>
          </div>
          <div class="modal fade" id="bannerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                          <h3 class="modal-title text-primary" id="myModalLabel">Choose Banner </h3>
                      </div>

                      <div class="modal-body manufacturer-image-embed">
                        <div class="form-group">
                          <label for="name" class="col-sm-12 col-md-12 control-label">Banner URL</label>
                          <div class="col-sm-12 col-md-12">
                              <input  :value="url" @input="url = $event.target.value"   type="text" class="form-control field-validate">
                              <span class="help-block hidden">This field is required.</span>
                          </div>
                      </div>
                      <div class="form-group" style="margin-top:10px;">
                        <label for="name" class="col-sm-12 col-md-12 control-label">Select Image</label>
                      </div>

                        <img data-dismiss="modal" style="width:120px; height:120px; margin:5px;border:1px solid lightgrey" v-for="image in images" @click="update(image.id)"  class="img-fluid"v-bind:src="'/'+image.path" alt="Banner Image">
                        <div class="modal-footer">
                      </div>
                      </div>
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
                banner_id : '',
                banners_title : '',
                language_id : '',
                updated_banner: '',
                url:''
          }
        },

        methods: {
          updateBannerId(id,banners_title){
            this.banner_id = id;
            this.banners_title = banners_title;
          },
           update(image_id){
             axios.post('updatebanner', {
                    banner_id: this.banner_id,
                    image_id: image_id,
                    url:this.url,
                    style: this.banners_title
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
