<style>
.image-upload>input {
  display: none;
}
</style>
<template>
  <div class="container-fluid">
    <div  v-if="this.responses.themeSetResponse == 1" class="alert alert-success alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Success!</strong> Theme Has been activated!.
    </div>
    <div  v-if="this.responses.themeSetResponse == 0" class="alert alert-danger alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Opps!</strong> No Change has been made!.
    </div>
      <div class="row">
        <div class="col-sm-3 col-md-6 col-lg-4">
          <div class="container">
            <button  style="margin-top:10px; width:200px;"type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Select Header</button>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h3 class="modal-title text-primary" id="myModalLabel">Choose Header </h3>
                        </div>
                        <div class="modal-body manufacturer-image-embed">
                          <img data-dismiss="modal" v-for="header in headers" @click="HeaderSetter(header)" style="width:100%"  v-bind:src="'../../'+header.image">
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="container">
            <button  style="margin-top:10px; width:200px;"type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#carousalModal">Select Carousal</button>
            <!-- Modal -->
            <div class="modal fade" id="carousalModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h3 class="modal-title text-primary" id="myModalLabel">Choose Carousal </h3>
                        </div>
                        <div class="modal-body manufacturer-image-embed">
                          <img data-dismiss="modal" v-for="carousal in carousals" @click="CarousalSetter(carousal)" style="width:100%"  v-bind:src="'../../'+carousal.image">
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="container">
            <button  style="margin-top:10px; width:200px;"type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#bannerModal">Select Banner</button>
            <!-- Modal -->
            <div class="modal fade" id="bannerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h3 class="modal-title text-primary" id="myModalLabel">Choose Banner </h3>
                        </div>
                        <div class="modal-body manufacturer-image-embed">
                          <img data-dismiss="modal" v-for="banner in banners" @click="BannerSetter(banner)" style="width:100%"  v-bind:src="'../../'+banner.image">
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="container">
            <button  style="margin-top:10px; width:200px;"type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#footerModal">Select Footer</button>
            <!-- Modal -->
            <div class="modal fade" id="footerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h3 class="modal-title text-primary" id="myModalLabel">Choose Footer </h3>
                        </div>
                        <div class="modal-body manufacturer-image-embed">
                          <img data-dismiss="modal" v-for="footer in footers" @click="FooterSetter(footer)" style="width:100%"  v-bind:src="'../../'+footer.image">
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="container">
            <button  style="margin-top:10px; width:200px;"type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#bannerImagesModal">Add Banner Images</button>
            <!-- Modal -->
            <div class="modal fade" id="bannerImagesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h3 class="modal-title text-primary" id="myModalLabel">Add Images</h3>
                        </div>
                        <div class="modal-body manufacturer-image-embed">
                          <div style="border: 1px solid lightgrey">
                            <h2>style 2</h2>
                           <div class="image-upload">
                           <label for="file-input">
                            <img style="width:150px; margin:10px;" v-for="banners_for_style in banners_for_styles" v-if="banners_for_style.type == 6" class="img-fluid" v-bind:src="'../../'+banners_for_style.path" alt="Banner Image">
                           </label>
                           <input id="file-input"   type="file" />
                           </div>
                           <div class="image-upload">
                           <label for="file-input1">
                            <img style="width:150px; margin:10px;" v-for="banners_for_style in banners_for_styles" v-if="banners_for_style.type == 8" class="img-fluid" v-bind:src="'../../'+banners_for_style.path" alt="Banner Image">
                            </label>
                            <input id="file-input1" type="file" />
                            </div>
                            <img style="width:150px; margin:10px;" v-for="banners_for_style in banners_for_styles" v-if="banners_for_style.type == 9" class="img-fluid" v-bind:src="'../../'+banners_for_style.path" alt="Banner Image">
                            <img style="width:150px; margin:10px;" v-for="banners_for_style in banners_for_styles" v-if="banners_for_style.type == 7" class="img-fluid" v-bind:src="'../../'+banners_for_style.path" alt="Banner Image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>

        <div class="col-sm-9 col-md-6 col-lg-8" style="">
          <img   style="width:100%" v-for="header in headers" v-if="header.id == current_theme.header && path_of_header == ''" v-bind:src="'../../'+header.image">
          <img   style="width:100%" v-if="path_of_header != ''" v-bind:src="'../../'+path_of_header">
          <img   style="width:100%" v-for="carousal in carousals" v-if="carousal.id == current_theme.carousel && path_of_carousal == ''" v-bind:src="'../../'+carousal.image">
          <img   style="width:100%" v-if="path_of_carousal != ''" v-bind:src="'../../'+path_of_carousal">
          <draggable v-model="product_section_orderss" @change="update">
              <div v-for="product_section_order in product_section_orderss">
                 <img v-if="product_section_order['id'] != 1" style="width:100%" v-bind:alt="product_section_order['name']" v-bind:src="'../../'+product_section_order['image']">
                 <img v-for="banner in banners" style="width:100%" v-if="product_section_order['id'] == 1 && banner.id == current_theme.banner && path_of_banner == ''"  v-bind:alt="product_section_order['name']" v-bind:src="'../../'+banner.image">
                 <img style="width:100%" v-if="product_section_order['id'] == 1 && path_of_banner != ''"  v-bind:src="'../../'+path_of_banner">
               </div>
         </draggable>
         <img   style="width:100%" v-for="footer in footers" v-if="footer.id == current_theme.footer && path_of_footer == ''" v-bind:src="'../../'+footer.image">
         <img   style="width:100%" v-if="path_of_footer != ''" v-bind:src="'../../'+path_of_footer">
        </div>
        <div class="box-footer text-right">
            <button type="#" @click="setTheme()" class="btn btn-primary">Apply </button>
        </div>
      </div>
    </div>
</template>

<script>
import draggable from 'vuedraggable'

    export default {
      components: {
        draggable
        },
        props: [
          'data'
        ],
        data() {
          return {
              formRequest: {
                header_id : this.data.current_theme.header,
                carousel_id : this.data.current_theme.carousel,
                banner_id : this.data.current_theme.banner,
                footer_id : this.data.current_theme.footer,
                cart_id : 1,
                news_id : 1,
                detail_id : 1,
                shop_id : 1,
                contact_id : 1
              },
              fileupload : '',
              responses:{
                themeSetResponse : -1
              },
              headers : this.data.data.headers,
              carousals : this.data.data.carousels,
              banners : this.data.data.banners,
              product_section_orderss : this.data.data.product_section_order,
              footers : this.data.data.footers,
              current_theme : this.data.current_theme,
              banners_for_styles :  this.data.data.homeBanners,
              path_of_header : '',
              path_of_carousal : '',
              path_of_banner : '',
              path_of_footer : ''

          }
        },

        methods: {
          previewFiles() {
            axios.post('test', {
                   file: this.fileupload
                 })
                 .then(response => {
                   if(response.status===200){
                     this.responses.themeSetResponse = response.data;
                      window.scrollTo(0,0);
                   }
                 })
                 .catch(function (error) {
                   console.log(error);
                 });
          },
           HeaderSetter(header){
             this.path_of_header = header.image;
             this.formRequest.header_id = header.id;
           },
           CarousalSetter(carousal){
             this.path_of_carousal = carousal.image;
             this.formRequest.carousel_id = carousal.id;
           },
           BannerSetter(banner){
             this.path_of_banner = banner.image;
             this.formRequest.banner_id = banner.id;
           },
           FooterSetter(footer){
             this.path_of_footer = footer.image;
             this.formRequest.footer_id = footer.id;
           },
           update(){
             this.product_section_orderss.map((product_section_orders, index) => {
               product_section_orders.order = index + 1;
             })
             axios.post('reorder', {
               product_section_orders : this.product_section_orderss
              }).then((response) => {
             })
           },
           setTheme(){
             axios.post('set', {
                    request: this.formRequest
                  })
                  .then(response => {
                    if(response.status===200){
                      this.responses.themeSetResponse = response.data;
                       window.scrollTo(0,0);
                    }
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
           }

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
