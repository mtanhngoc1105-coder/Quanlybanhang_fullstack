import axiosInstance from "../api/axiosInstance"

const API = "/postoffices"

export const getPostOffices = () => axiosInstance.get(API)
export const getPostOffice = (id) => axiosInstance.get(`${API}/${id}`)
export const createPostOffice = (data) => axiosInstance.post(API, data)
export const updatePostOffice = (id,data) => axiosInstance.put(`${API}/${id}`, data)
export const deletePostOffice = (id) => axiosInstance.delete(`${API}/${id}`)