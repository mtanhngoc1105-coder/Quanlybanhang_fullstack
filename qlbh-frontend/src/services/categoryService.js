import axiosInstance from "../api/axiosInstance"

const API = "/categories"

export default {
  getAll: () => axiosInstance.get(API),
  get: (id) => axiosInstance.get(`${API}/${id}`),
  create: (data) => axiosInstance.post(API, data),
  update: (id, data) => axiosInstance.put(`${API}/${id}`, data),
  delete: (id) => axiosInstance.delete(`${API}/${id}`)
}
