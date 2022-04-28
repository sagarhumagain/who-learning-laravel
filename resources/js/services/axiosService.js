import axios from 'axios';
import store from "@/store"

class AxiosService {
  
  constructor() {
    let service = axios.create({});
    service.interceptors.request.use((config) => {
      config.headers.common['x-access-token'] = store.state.token
      return config
    })
    this.service = service;
  }
  
  redirectTo = (document, path) => {
    document.location = path
  }
  
  get(path) {
    return this.service.get(path)
  }

  patch(path, payload, callback) {
    return this.service.request({
      method: 'PATCH',
      url: path,
      responseType: 'json',
      data: payload
    }).then((response) => callback(response.status, response.data));
  }

  post(path, payload) {
    return this.service.request({
      method: 'POST',
      url: path,
      responseType: 'json',
      data: payload
    })
  }
}

export default new import axios from 'axios';
import store from "@/data/state"

class Http {
  
  constructor() {
    let service = axios.create({});
    service.interceptors.request.use((config) => {
      config.headers.common['x-access-token'] = store.state.token
      return config
    })
    this.service = service;
  }
  
  redirectTo = (document, path) => {
    document.location = path
  }
  
  get(path) {
    return this.service.get(path)
  }

  patch(path, payload, callback) {
    return this.service.request({
      method: 'PATCH',
      url: path,
      responseType: 'json',
      data: payload
    }).then((response) => callback(response.status, response.data));
  }

  post(path, payload) {
    return this.service.request({
      method: 'POST',
      url: path,
      responseType: 'json',
      data: payload
    })
  }
}

export default new AxiosService;