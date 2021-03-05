<template>
  <div>
    <div class="text-muted mb-2">
      <i class="el-icon-paperclip"></i>
      {{ $t("Attachments") }}
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="media border rounded p-2 mb-2" v-for="(attachment, i) in attachments" :key="attachment.id">
          <a href="#" @click.prevent="index = i; visible = true">
            <el-image
              fit="cover"
              class="mr-3 border"
              style="height: 50px;width:50px"
              :src="attachment.url"
            >
            <div slot="error" class="image-slot text-center" style="line-height:50px">
              <i class="el-icon-document" style="font-size:30px;margin-top:10px"></i>
            </div>
            </el-image>
          </a>
          <div class="media-body d-flex justify-content-between">
            <div>
              <strong> {{attachment.name}} </strong>
              <div class="text-muted"> {{bytesToSize(attachment.size)}} </div>
              <div class="text-muted"> {{attachment.type}} </div>
            </div>
            <div>
              <el-button @click="download(attachment.url)" icon="el-icon-download"></el-button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <vue-easy-lightbox
      :visible="visible"
      :imgs="attachments.map(a => a.url)"
      :index="index"
      @hide="visible = false"
    ></vue-easy-lightbox>
  </div>
</template>

<script>
export default {
  props: ['attachments'],
  data() {
    return {
      index: 0,
      visible: false
    }
  },

  methods: {
    bytesToSize(bytes) {
      var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
      if (bytes == 0) return '0 Byte';
      var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
      return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    },

    download(url) {
      window.open(url, '_blank');
    }
  }
}
</script>
