import axios from "axios"

const API = "http://127.0.0.1:8000/api/categories"

export default {
  getAll: () => axios.get(API),
  get: (id) => axios.get(`${API}/${id}`),
  create: (data) => axios.post(API, data),
  update: (id, data) => axios.put(`${API}/${id}`, data),
  delete: (id) => axios.delete(`${API}/${id}`)
}
