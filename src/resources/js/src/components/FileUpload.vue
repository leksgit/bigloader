<template>
  <div class="container mt-5">
    <form @submit.prevent="submitForm" class="row g-3">
      <div class="col-auto">
        <label for="file" class="form-label">Upload a file:</label>
        <input type="file" id="file" ref="fileInput"
               :disabled="isProcessing"
               @change="fileSelected" class="form-control"/>
      </div>
      <div class="col-auto">
        <button type="submit"
                :disabled="isProcessing"
                class="btn btn-primary">Upload</button>
      </div>
    </form>
    <p v-if="message" class="mt-3">{{ message }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      selectedFile: null,
      message: null,
      intervalSeconds: null
    };
  },
  computed: {
    isProcessing() {
      return this.intervalSeconds !== null;
    }
  },
  methods: {
    fileSelected(event) {
      this.selectedFile = event.target.files[0];
      this.message = "File selected. Ready to upload.";
    },
    async submitForm() {
      if (!this.selectedFile) {
        this.message = 'No file selected.';
        return;
      }
      const formData = new FormData();
      formData.append('file', this.selectedFile);

      try {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const response = await axios.post('/upload', formData);

        this.startCheckingStatus();

        this.message = response.data.message || 'Failed to upload file.';
      } catch (error) {
        this.message = 'An error occurred during the upload.';
      }
    },
    async checkStatus() {
      if (this.intervalSeconds) {
        try {
          const response = await axios.get("/status");
          if (response.data.is_done === true) {
            this.stopCheckingStatus();
          }
          this.message = response.data.message;
        } catch (error) {
          console.error("Error checking status:", error);
        }
      }
    },
    startCheckingStatus() {
      this.stopCheckingStatus(); // Stop any existing intervals
      this.intervalSeconds = setInterval(this.checkStatus, 5000); // Every 5 seconds
    },
    stopCheckingStatus() {
      if (this.intervalSeconds) {
        clearInterval(this.intervalSeconds);
        this.intervalSeconds = null;
      }
    }
  },
  beforeDestroy() {
    this.stopCheckingStatus();
  }
};
</script>
