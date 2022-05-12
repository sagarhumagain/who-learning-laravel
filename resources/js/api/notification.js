
export default (baseUrl, apiVersion) => ({
    async fetchAllNotification() {
      return await axios.get(`${baseUrl}${apiVersion}/notifications`);
    },
  });