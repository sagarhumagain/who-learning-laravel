
export default (baseUrl, apiVersion) => ({
    async fetchAllNotification() {
      return await axios.get(`${baseUrl}/api/v1/notifications`);
    },
  });