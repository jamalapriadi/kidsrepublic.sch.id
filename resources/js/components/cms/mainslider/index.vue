<template>
    <div>
        <div class="card card-default">
            <div class="card-header">Slide Overlay</div>
            <div class="card-body">
                <form @submit.prevent="storeOverlay" action="data/carousel-overlay" method="post">
                    <vue-loading v-if="loading3" type="bars" color="#d9544e" :size="{ width: '50px', height: '50px' }"></vue-loading>    
                    <div v-if="messageoverlay" v-bind:class="pesankelasoverlay">
                        {{ messageoverlay }}
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label">Text Overlay</label>
                        <!-- <trumbowyg v-model="overlay.desc"  :config="configText" class="form-control" name="content"></trumbowyg> -->
                        <textarea name="desc" id="desc" v-model="overlay.desc" cols="30" rows="10"></textarea>
                    </div>

                    <hr>
                    <div class="form-group">
                        <button class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Save
                        </button>   
                    </div>
                </form>
            </div>
        </div>

        <div class="card card-default">
            <div class="card-header">Slide Carousel</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-default">
                            <div class="card-header">Add New Carousel</div>
                            <div class="card-body">
                                <vue-loading v-if="loading2" type="bars" color="#d9544e" :size="{ width: '50px', height: '50px' }"></vue-loading>    
                                <div v-if="message" v-bind:class="pesankelas">
                                    {{ message }}
                                </div>

                                <form @submit.prevent="store" action="data/carousel" method="post">
                                    <div class="form-group">
                                        <label for="" class="control-label">Caption</label>
                                        <input type="text" class="form-control" v-model="state.caption">
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="control-label">Text</label>
                                        <input type="text" class="form-control" v-model="state.text">
                                    </div>  

                                    <div class="card card-default" v-show="showPreview">
                                        <div class="card-header">Images Info</div>
                                        <div class="card-body">
                                            <img v-bind:src="state.filepreview" class="img-fluid" v-bind:style="{ 'height': state.height+'px', 'width': state.width+'px', 'border-top-left-radius': state.border_radius.top_left+'px', 'border-top-right-radius': state.border_radius.top_right+'px', 'border-bottom-left-radius': state.border_radius.bottom_left+'px', 'border-bottom-right-radius': state.border_radius.bottom_right+'px'}">
                                            
                                            <br><br>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <fieldset>
                                                        <div class="form-group">
                                                            <label for="" class="control-label">Width</label>
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" v-model="state.width">
                                                                <span class="input-group-append">
                                                                    <button class="btn btn-secondary" type="button">px</button>
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="" class="control-label">Height</label>
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" v-model="state.height">
                                                                <span class="input-group-append">
                                                                    <button class="btn btn-secondary" type="button">px</button>
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="" class="control-label">Border Radius</label>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-append">
                                                                            <button class="btn btn-secondary" type="button">Top Left</button>
                                                                        </span>
                                                                        <input type="text" class="form-control" v-model="state.border_radius.top_left">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-append">
                                                                            <button class="btn btn-secondary" type="button">Top Right</button>
                                                                        </span>
                                                                        <input type="text" class="form-control" v-model="state.border_radius.top_right">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-append">
                                                                            <button class="btn btn-secondary" type="button">Bottom</button>
                                                                        </span>
                                                                        <input type="text" class="form-control" v-model="state.border_radius.bottom_left">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-append">
                                                                            <button class="btn btn-secondary" type="button">Bottom</button>
                                                                        </span>
                                                                        <input type="text" class="form-control" v-model="state.border_radius.bottom_right">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="" class="control-label">Alignment</label>
                                                            <select name="alignment" id="alignment" v-model="state.alignment" class="form-control">
                                                                <option value="left">Left</option>
                                                                <option value="right">Right</option>
                                                                <option value="center">Center</option>
                                                            </select>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Choose File</label><br>
                                            
                                        <div class="input-group">
                                            <input type="file" id="file" ref="file" accept="image/*" v-on:change="onFileChange" class="form-control"/>
                                            <span class="input-group-addon" id="removeFeaturedImage">
                                                <i class=" icon-cross3"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="form-group">
                                        <button class="btn btn-primary">
                                            <i class="fa fa-save"></i>
                                            Tambah
                                        </button>   

                                        <a href="#" @click="kosong()" class="btn btn-default">
                                            Batal    
                                        </a>           
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card card-default">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <form class="form-inline">
                                            <div class="form-group">
                                                <label for="" class="control-label col-lg-4">FILTER:</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="q" id="q" placeholder="Type and Enter" v-model="pencarian">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <br>
                                
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Image</th>
                                                <th>Caption</th>
                                                <th>Text</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(l, index) in list.data" v-bind:key="index">
                                                <td>{{index+1}}</td>
                                                <td>
                                                    <img :src="l.image_url" alt="" class="img-fluid" style="height:120px;">
                                                </td>
                                                <td>{{l.caption}}</td>
                                                <td>
                                                    <div v-html="l.text"></div>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-warning" @click="updateCarousel(l.id)">
                                                            <i class="fa fa-edit text-white"></i>
                                                        </a>

                                                        <a class="btn btn-danger" v-on:click="hapus(l.id, index)" v-bind:id="'delete'+l.id">
                                                            <i class="fa fa-trash text-white"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <vue-loading v-if="loading" type="bars" color="#d9544e" :size="{ width: '50px', height: '50px' }"></vue-loading>    
                                <div align="right">
                                    <pagination :data="listData" @pagination-change-page="showData" :show-disabled="true"></pagination>
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
    import { VueLoading } from 'vue-loading-template'
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    import Trumbowyg from 'vue-trumbowyg';
  
    // Import editor css
    import 'trumbowyg/dist/ui/trumbowyg.css';
    import 'trumbowyg/plugins/fontsize/trumbowyg.fontsize';
    import 'trumbowyg/plugins/fontfamily/trumbowyg.fontfamily';

    export default {
        components: {
            VueLoading,
            Trumbowyg
        },
        data(){
            return {
                state:{
                    caption:'',
                    text:'',
                    file:'',
                    filepreview:'',
                    height:720,
                    width:1280,
                    border_radius:{
                        top_left:0,
                        top_right:0,
                        bottom_left:0,
                        bottom_right:0
                    },
                    alignment:'left'
                },
                overlay:{
                    desc:'',
                    kode:''
                },
                list:[],
                categories:[],
                listData:{},
                pencarian:'',
                pesankelas:'',
                message:'',
                loading:true,
                loading2:false,
                loading3:false,
                messageoverlay:'',
                pesankelasoverlay:'',
                editor: ClassicEditor,
                editorConfig: {
                    // The configuration of the editor.
                },
                showPreview:false,
                configText:{
                    btns: [
                        ['viewHTML'],
                        ['fontfamily'],
                        ['fontsize'],
                        ['undo', 'redo'], // Only supported in Blink browsers
                        ['formatting'],
                        ['strong', 'em', 'del'],
                        ['superscript', 'subscript'],
                        ['link'],
                        ['insertImage'],
                        ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                        ['unorderedList', 'orderedList'],
                        ['horizontalRule'],
                        ['removeformat'],
                        ['fullscreen'],
                    ],
                    plugins: {
                        fontsize: {
                            sizeList: [
                                '5px',
                                '9px',
                                '10px',
                                '11px',
                                '12px',
                                '14px',
                                '16px',
                                '18px',
                                '20px',
                                '22px',
                                '24px',
                                '26px',
                                '28px',
                                '36px',
                                '48px',
                            ],
                            allowCustomSize: false
                        }
                    },
                    autogrow: true,
                    changeActiveDropdownIcon: true
                }   
            }
        },
        mounted() {
            this.showData();
            this.getCategory();
            this.getOverlay();
        },
        watch: {
            pencarian: function(q) {
                if (q != ''){
                    this.cariData();
                }else{
                    this.showData();
                }
            }
        },
        methods: {
            emptyEditor() {
                this.state.desc = '';
            },

            getCKeditor(){
                CKEDITOR.replace( 'desc',{
                    extraPlugins : ['btgrid','wenzgmap','bootstrapTabs','link'],
                    language: 'en',
                    allowedContent: true,
                    entities: false,
                    enterMode:2,forceEnterMode:false,shiftEnterMode:1,
                    toolbar :
                        [
                            [ 'Font', 'FontSize','Styles' ],        
                            [ 'Bold', 'Italic', 'Underline'],
                            [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ],
                            ['TextColor','BGColor'],
                            [ 'Paste', 'PasteText', 'PasteFromWord'],
                            '/',
                            [ 'NumberedList', 'BulletedList', '-','JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
                            [ 'Link','Anchor','btgrid','About','wenzgmap','BootstrapTabs','Source','Maximize'],
                        ],
                    toolbarGroupsCanCollapse:true,
                    filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
                    filebrowserWindowWidth: '1000',
                    filebrowserWindowHeight: '700'
                });
            },

            getOverlay(){
                axios.get('data/carousel-overlay')
                    .then(response => {
                        if(response.data!=null){
                            this.overlay.kode = response.data.id
                            this.overlay.desc = response.data.text
                        }

                        this.getCKeditor()
                        
                    })
            },

            getCategory(){
                axios.get('data/list-category')
                    .then(response => {
                        this.categories=response.data
                    })
            },

            paginate(url){
                axios.get(url)
                    .then(response => {
                        this.list = response.data;
                    })
            },

            showData(page){
                if(typeof page === 'undefined'){
                    page = 1;
                }

                axios.get('data/carousel?page='+page)
                    .then(response => {
                        this.loading=false;
                        this.list = response.data;
                        this.listData = response.data;
                    })
            },

            cariData(page){
                if(typeof page === 'undefined'){
                    page = 1;
                }

                axios.get('data/carousel?q='+this.pencarian)
                    .then(response => {
                        this.list = response.data;
                    })
                    .catch( errors => {
                        alert('pencarian tidak ditemukan');
                    })
            },

            onFileChange(e) {
                let file = this.$refs.file.files[0];
                if(!file || file.type.indexOf('image/') !== 0) return;
                
                let reader = new FileReader();
                
                reader.readAsDataURL(file);
                reader.onload = evt => {
                    let img = new Image();
                    img.onload = () => {
                        this.state.width = img.width
                        this.state.height = img.height
                        console.log(img.width+' - '+img.height)
                    }
                    img.src = evt.target.result;
                }
                

                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;

                let ukuran = files[0].size;

                if(ukuran > 1000000){
                    this.$swal('Warning', 'Ukuran file image tidak boleh lebih dari 1 MB' , 'warning');
                    return;
                }

                if(files[0]['type']==='image/jpeg' || files[0]['type']==='image/png' || files[0]['type']==='image/jpg'){
                    this.createImage(files[0]);
                }else{
                    this.$swal('Warning', 'Format file tidak diketahui' , 'warning');
                    return;
                }
            },

            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.state.file = e.target.result;
                    vm.state.filepreview = e.target.result;
                    vm.showPreview = true;
                };
                reader.readAsDataURL(file);
            },

            hapus(id,index,name){
                this.$swal({
                    title: 'Are you sure?',
                    text: 'You can\'t revert your action',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes Delete it!',
                    cancelButtonText: 'No, Keep it!',
                    showCloseButton: true,
                    showLoaderOnConfirm: true
                })
                .then((result) => {
                    if(result.value) {
                        axios.delete('data/carousel/'+id)
                            .then(response => {
                                if(response.data.success==true){
                                    this.message="";
                                    this.$swal('Deleted', response.data.pesan , 'success');
                                    this.showData();
                                    this.kosong()
                                }else{
                                    this.$swal('Deleted', response.data.pesan , 'error');
                                }
                            })
                        
                    } else {
                        this.$swal('Cancelled', 'Your file is still intact', 'info')
                    }
                })
            },

            store(e) {
                this.loading2=true;
                axios.post(e.target.action, this.state).then(response => {
                    this.loading2=false;
                    if(response.data.success==true){
                        this.errors = [];
                        this.state={
                            caption:'',
                            text:'',
                            file:'',
                            filepreview:'',
                            height:720,
                            width:1280,
                            border_radius:{
                                top_left:0,
                                top_right:0,
                                bottom_left:0,
                                bottom_right:0
                            },
                            alignment:'left'
                        }
                        this.showPreview=false
                        this.message = 'Data berhasil disimpan';
                        this.pesankelas='alert alert-success';
                        this.showData();
                    }else{
                        this.pesankelas='alert alert-danger';
                        this.message = response.data.errors;
                        this.errors.nama=true;
                    }
                }).catch(error => {
                    if (! _.isEmpty(error.response)) {
                        if (error.response.status = 422) {
                            this.errors = error.response.data;
                            console.log(this.errors);
                        }
                    }
                });
            },

            updateCarousel(id){
                this.state.kode=id;
                this.message='';

                axios.get('data/carousel/'+id)
                    .then(response => {
                        this.state.kode = response.data.id;
                        this.state.caption = response.data.caption;
                        this.state.text=response.data.text;
                        this.state.width = response.data.image_width;
                        this.state.height = response.data.image_height;
                        this.state.alignment = response.data.image_alignment;
                        this.state.border_radius={
                            top_left: response.data.image_border_top_left_radius,
                            top_right: response.data.image_border_top_right_radius,
                            bottom_left: response.data.image_border_bottom_left_radius,
                            bottom_right: response.data.image_border_bottom_right_radius
                        }
                        
                        if(response.data.image!=null){
                            this.state.filepreview=response.data.image_url;
                            this.showPreview=true;
                        }
                    })
                    .catch( error => {
                        alert('data tidak dapat di load');
                    })
            },

            kosong(){
                this.state={
                    caption:'',
                    text:'',
                    file:'',
                    filepreview:'',
                    height:720,
                    width:1280,
                    border_radius:{
                        top_left:0,
                        top_right:0,
                        bottom_left:0,
                        bottom_right:0
                    },
                    alignment:'left'
                }
                this.showPreview=false
                this.message=''
            },

            storeOverlay(e) {
                this.loading3=true;

                this.overlay.desc = CKEDITOR.instances.desc.getData();

                axios.post(e.target.action, this.overlay).then(response => {
                    this.loading3=false;
                    if(response.data.success==true){
                        this.messageoverlay = 'Data berhasil disimpan';
                        this.pesankelasoverlay='alert alert-success';
                        this.getOverlay();
                    }else{
                        this.messageoverlay='alert alert-danger';
                        this.pesankelasoverlay = response.data.errors;
                    }
                }).catch(error => {
                    if (! _.isEmpty(error.response)) {
                        if (error.response.status = 422) {
                            this.errors = error.response.data;
                            console.log(this.errors);
                        }
                    }
                });
            },
        }
    }
</script>

<style>
    .ck-editor__editable {
        min-height: 200px;
    }
</style>
