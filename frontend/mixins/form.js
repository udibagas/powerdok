export default {
  data() {
    return {
      loading: false,
      errors: {},
    }
  },

  methods: {

    submit(id) {
      this.$axios({
        method: id > 0 ? 'put' : 'post',
        url: id > 0 ? `${this.url}/${id}` : this.url,
        data: this.model
      }).then(r => {
        this.$message({
          message: r.data.message,
          type: 'success'
        })
        this.closeForm(r.data)
        this.$emit('refresh')
      }).catch(e => {
        this.$message({
          message: e.response.data.message,
          type: 'error'
        })

        if (e.response.status == 422) {
          this.errors = e.response.data.errors
        }
      }).finally(() => this.loading = false)
    },

    closeForm(data) {
      this.errors = {}
      this.$emit('close')
    },

    upload(params) {
      console.log(params);
      const { file, onError, onSuccess, onProgress, data } = params;

      let formData = new FormData();
      formData.append('file', file);
      formData.append('data', data);

      this.$axios.$post('/api/upload', formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
        onUploadProgress: (e) => {
          let percent = (e.loaded / e.total * 100) | 0;
          onProgress( { percent } );
        },
      }).then((response) => onSuccess(response)).catch(e => onError(e.response))
    },

    handlePreview() {
      //
    },

    handleRemove(file, fileList) {
      console.log(file)
      const indexFile = this.model.attachments.findIndex(f => f.uid == file.uid)
      this.model.attachments.splice(indexFile, 1);
      console.log(this.model.attachments);
    },

		handleUploadFileSuccess(res, file, fileList) {
      this.$message({ message: res.message, type: 'success' });

      if (this.model.attachments == null) {
        this.model.attachments = [];
      }

      this.model.attachments.push(res);
		},

		handleUploadFileError(err, file, fileList) {
      console.log(err);
      let message =  ''

			if (err.status == 413) {
				message = this.$t('Failed to upload document. File too big.')
			}

			if (err.status == 422) {
				message = err.data.errors.file[0]
			}

			if (err.status == 500) {
				message = err.data.message
			}

			this.$message({
				message: message,
				type: 'error',
				showClose: true,
				duration: 10000,
			})
		}

  }
}
