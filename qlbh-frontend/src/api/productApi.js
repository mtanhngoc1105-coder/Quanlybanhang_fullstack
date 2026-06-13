// src/api/productApi.js
import axiosInstance from "./axiosInstance";

const API_URL = "/products";

export const getProducts = (search = "", page = 1) => {
  return axiosInstance.get(`${API_URL}?search=${search}&page=${page}`);
};

export const getProduct = (id) => {
  return axiosInstance.get(`${API_URL}/${id}`);
};

export const createProduct = (data) => {
  return axiosInstance.post(API_URL, data);
};

export const updateProduct = (id, data) => {
  return axiosInstance.put(`${API_URL}/${id}`, data);
};

export const deleteProduct = (id) => {
  return axiosInstance.delete(`${API_URL}/${id}`);
};