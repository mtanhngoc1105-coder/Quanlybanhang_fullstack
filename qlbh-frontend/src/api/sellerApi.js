// src/api/sellerApi.js
import axiosInstance from "./axiosInstance";

const API_URL = "/sellers";

export const getSellers = (search = "", page = 1) => {
  return axiosInstance.get(`${API_URL}?search=${search}&page=${page}`);
};

export const getSeller = (id) => {
  return axiosInstance.get(`${API_URL}/${id}`);
};

export const createSeller = (data) => {
  return axiosInstance.post(API_URL, data);
};

export const updateSeller = (id, data) => {
  return axiosInstance.put(`${API_URL}/${id}`, data);
};

export const deleteSeller = (id) => {
  return axiosInstance.delete(`${API_URL}/${id}`);
};
