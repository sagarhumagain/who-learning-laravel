import store from '@/store';
export default (baseUrl, apiVersion) => ({
    async fetchAllNotification() {
      return await axios.get(`${baseUrl}${apiVersion}/notifications`)
      .catch(err => {
          if (err.response.status === 401) {
              store.dispatch('auth/logout');
              router.push({name:'login'});
          }
          throw err;
        }
        );
    },

  });
