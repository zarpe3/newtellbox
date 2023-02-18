<template>
  <div class="example-full">
    <div v-show="$refs.upload && $refs.upload.dropActive" class="drop-active">
      <h3>Solte os arquivos para upload</h3>
    </div>
    <div class="upload" v-show="!isOption">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th></th>
              <th>Nome</th>
              <th v-if="isImage">Largura</th>
              <th v-if="isImage">Altura</th>
              <th>Tamanho</th>
              <th>Estado</th>
              <th>Ação</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="!files.length">
              <td colspan="9" style="display: revert; !important;">
                <div class="text-center p-5">
                  <h4>Solte os arquivos em qualquer lugar para fazer upload <br> ou</h4>
                  <label :for="name" class="btn btn-lg btn-primary">Selecionar arquivos</label>
                </div>
              </td>
            </tr>
            <tr v-for="(file, index) in files" :key="file.id">
              <td>
                <img class="td-image-thumb" v-if="file.thumb" :src="file.thumb" />
                <span v-else>Arquivo</span>
              </td>
              <td>
                <div class="filename">
                  {{ file.name }}
                </div>
                <div class="progress" v-if="file.active || file.progress !== '0.00'">
                  <div
                    :class="{ 'progress-bar': true, 'progress-bar-striped': true, 'bg-danger': file.error, 'progress-bar-animated': file.active }"
                    role="progressbar" :style="{ width: file.progress + '%' }">{{ file.progress }}%</div>
                </div>
              </td>
              <td v-if="isImage">{{ file.width || 0 }}</td>
              <td v-if="isImage">{{ file.height || 0 }}</td>
              <td>{{ formatSize(file.size) }}</td>
              
              <td v-if="file.error">{{ messageError(file.error) }}</td>
              <td v-else-if="file.success">Arquivo enviado</td>
              <td v-else-if="file.active">Enviando arquivo</td>
              <td v-else></td>
              <td>
                <div class="btn-group">
                  <a class="dropdown-item" href="#" @click.prevent="$refs.upload.remove(file)">Remove</a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="example-foorer">
        <div class="btn-group">
          <file-upload class="btn btn-primary" :post-action="postAction"
            :extensions="extensions" :accept="accept" :multiple="multiple" :directory="directory"
            :create-directory="createDirectory" :size="size || 0" :thread="thread < 1 ? 1 : (thread > 5 ? 5 : thread)"
            :headers="headers" :data="this.$parent.data" :drop="drop" :drop-directory="dropDirectory" :add-index="addIndex"
            v-model="files" @input-filter="inputFilter" @input-file="inputFile" ref="upload">
            <i class="fa fa-plus"></i>
            Selecionar
          </file-upload>
        </div>
        <button type="button" class="btn btn-success" v-if="!$refs.upload || !$refs.upload.active"
          @click.prevent="$refs.upload.active = true">
          <i class="fa fa-arrow-up" aria-hidden="true"></i>
          Iniciar o Envio
        </button>
        <button type="button" class="btn btn-danger" v-else @click.prevent="$refs.upload.active = false">
          <i class="fa fa-stop" aria-hidden="true"></i>
          Parar o Envio
        </button>
      </div>
    </div>
  </div>
</template>
<style>
.example-full .btn-group .dropdown-menu {
  display: block;
  visibility: hidden;
  transition: all .2s
}
.example-full .btn-group:hover > .dropdown-menu {
  visibility: visible;
}

.example-full label.dropdown-item {
  margin-bottom: 0;
}

.example-full .btn-group .dropdown-toggle {
  margin-right: .6rem
}

.td-image-thumb {
  max-width: 4em;
  max-height: 4em;
}

.example-full .filename {
  margin-bottom: .3rem
}

.example-full .btn-is-option {
  margin-top: 0.25rem;
}
.example-full .example-foorer {
  padding: .5rem 0;
  border-top: 1px solid #e9ecef;
  border-bottom: 1px solid #e9ecef;
}


.example-full .edit-image img {
  max-width: 100%;
}

.example-full .edit-image-tool {
  margin-top: .6rem;
}

.example-full .edit-image-tool .btn-group{
  margin-right: .6rem;
}

.example-full .footer-status {
  padding-top: .4rem;
}

.example-full .drop-active {
  top: 0;
  bottom: 0;
  right: 0;
  left: 0;
  position: fixed;
  z-index: 9999;
  opacity: .6;
  text-align: center;
  background: #000;
}

.example-full .drop-active h3 {
  margin: -.5em 0 0;
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  -webkit-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
  font-size: 40px;
  color: #fff;
  padding: 0;
}
</style>

<script>
import Cropper from 'cropperjs'
import ImageCompressor from '@xkeshi/image-compressor'
import FileUpload from 'vue-upload-component'
export default {
  components: {
    FileUpload,
  },
  props: ['config'],
  data() {
    return {
      files: [],
      required: [],
      isImage: true,
      accept: 'image/png,image/gif,image/jpeg,image/webp',
      extensions: 'gif,jpg,jpeg,png,webp',
      minSize: 0,
      size: 1024 * 1024 * 1,
      multiple: false,
      directory: false,
      drop: true,
      dropDirectory: true,
      createDirectory: false,
      addIndex: false,
      thread: 3,
      name: 'file',
      postAction: '',
      headers: {
        'X-Csrf-Token': window.Laravel.csrfToken,
      },
      data: this.$parent.data,
      autoCompress: 1024 * 1024,
      uploadAuto: false,
      isOption: false,
      addData: {
        show: false,
        name: '',
        type: '',
        content: '',
      },

      editFile: {
        show: false,
        name: '',
      },
      customMessage: '',
    }
  },
  mounted() {
    if(this.$props.config !== undefined){
      this.isImage = this.$props.config.isImage !== undefined ? this.$props.config.isImage : true
      this.accept = this.$props.config.accept !== undefined ? this.$props.config.accept : 'image/png,image/gif,image/jpeg,image/webp'
      this.extensions = this.$props.config.extensions !== undefined ? this.$props.config.extensions : 'gif,jpg,jpeg,png,webp'
      this.minSize = this.$props.config.minSize !== undefined ? this.$props.config.minSize : 0
      this.size = this.$props.config.size !== undefined ? this.$props.config.size : 1024 * 1024 * 1
      this.multiple = this.$props.config.multiple !== undefined ? this.$props.config.multiple : false
      this.postAction = this.$props.config.postAction !== undefined ? this.$props.config.postAction : '/'
      this.multiple = this.$props.config.multiple !== undefined ? this.$props.config.multiple : false
      this.uploadAuto = this.$props.config.uploadAuto !== undefined ? this.$props.config.uploadAuto : false
      this.required = this.$props.config.required !== undefined ? this.$props.config.required : []
    }
  },
  watch: {
    
    'editFile.show'(newValue, oldValue) {
      // 关闭了 自动删除 error
      if (!newValue && oldValue) {
        this.$refs.upload.update(this.editFile.id, { error: this.editFile.error || '' })
      }
      if (newValue) {
        this.$nextTick( () => {
          if (!this.$refs.editImage) {
            return
          }
          let cropper = new Cropper(this.$refs.editImage, {
            autoCrop: false,
          })
          this.editFile = {
            ...this.editFile,
            cropper
          }
        })
      }
    },

    'addData.show'(show) {
      if (show) {
        this.addData.name = ''
        this.addData.type = ''
        this.addData.content = ''
      }
    },
  },

  methods: {
    messageError(error){
      if(error.includes('.')){
        error = string.split(".")[0];
        return error[1];
      }
      switch (error) {
        case 'size':
            return `Somente arquvo até ${this.formatSize(this.size)}`;
          break;
        case 'extension':
            return `Somente arquivo ${this.extensions}`;
          break;
        case 'custom':
            return this.customMessage;
          break;
        default:
          break;
      }
    },
    formatSize(size){
      if (size > 1024 * 1024 * 1024 * 1024) {
        return (size / 1024 / 1024 / 1024 / 1024).toFixed(2) + ' TB'
      } else if (size > 1024 * 1024 * 1024) {
        return (size / 1024 / 1024 / 1024).toFixed(2) + ' GB'
      } else if (size > 1024 * 1024) {
        return (size / 1024 / 1024).toFixed(2) + ' MB'
      } else if (size > 1024) {
        return (size / 1024).toFixed(2) + ' KB'
      }
      return size.toString() + ' B'
    },
    inputFilter(newFile, oldFile, prevent) {
      console.log(this.data)
      if (newFile && !oldFile) {
        if (/(\/|^)(Thumbs\.db|desktop\.ini|\..+)$/.test(newFile.name)) {
          return prevent()
        }

        if (/\.(php5?|html?|jsx?)$/i.test(newFile.name) && newFile.type !== "text/directory") {
          return prevent()
        }

        if (newFile.file && newFile.error === "" && newFile.type.substr(0, 6) === 'image/' && this.autoCompress > 0 && this.autoCompress < newFile.size) {
          newFile.error = 'compressing'
          const imageCompressor = new ImageCompressor(null, {
            convertSize: 1024 * 1024,
            maxWidth: 512,
            maxHeight: 512,
          })
          imageCompressor.compress(newFile.file)
            .then((file) => {
              this.$refs.upload.update(newFile, { error: '', file, size: file.size, type: file.type })
            })
            .catch((err) => {
              this.$refs.upload.update(newFile, { error: err.message || 'compress' })
            })
        }
      }


      if (newFile && newFile.error === "" && newFile.file && (!oldFile || newFile.file !== oldFile.file)) {
        console.log(newFile)
        newFile.blob = ''
        let URL = (window.URL || window.webkitURL)
        if (URL) {
          newFile.blob = URL.createObjectURL(newFile.file)
        }

        newFile.thumb = ''
        if (newFile.blob && newFile.type.substr(0, 6) === 'image/') {
          newFile.thumb = newFile.blob
        }
      }

      if (newFile && newFile.error === '' && newFile.type.substr(0, 6) === "image/" && newFile.blob && (!oldFile || newFile.blob !== oldFile.blob)) {
        newFile.error = 'image parsing'
        let img = new Image();
        img.onload = () => {
          this.$refs.upload.update(newFile, {error: '', height: img.height, width: img.width})
        } 
        img.οnerrοr = (e) => {
          this.$refs.upload.update(newFile, { error: 'parsing image size'}) 
        }
        img.src = newFile.blob
      }
    },

    // add, update, remove File Event
    inputFile(newFile, oldFile) {
      this.$parent.sendStatus()
      
      if (newFile && oldFile) {
        // update
        if (newFile.active && !oldFile.active) {
          // beforeSend
          if(this.$parent.required.length !== 0){
            if(this.$parent.send === false){
              let statusError = true
              let messageError = ''
              this.$parent.required.forEach(element => {
                if(statusError && (element.value === undefined || element.value === '')){
                  statusError = false
                  messageError = element.message
                }
              });
              this.customMessage = messageError
              this.$refs.upload.update(newFile, { error: 'custom' })
            }          
          }
          // min size
          if (newFile.size >= 0 && this.minSize > 0 && newFile.size < this.minSize && newFile.type !== "text/directory") {
            this.$refs.upload.update(newFile, { error: 'size' })
          }
        }

        if (newFile.progress !== oldFile.progress) {
          // progress
        }

        if (newFile.error && !oldFile.error) {
          // error
        }

        if (newFile.success && !oldFile.success) {
          console.log(newFile.response)
          // success
        }
      }

      // Automatically activate upload
      if (Boolean(newFile) !== Boolean(oldFile) || oldFile.error !== newFile.error) {
        if (this.uploadAuto && !this.$refs.upload.active) {
          this.$refs.upload.active = true
        }
      }
      
    },
  }
}
</script>