// src/api/orderApi.js
import axiosInstance from "./axiosInstance";

const API_URL = "/api/orders";

export const getOrders = (search = "", page = 1) => {
  return axiosInstance.get(`${API_URL}?search=${search}&page=${page}`);
};

export const getOrder = (id) => {
  return axiosInstance.get(`${API_URL}/${id}`);
};

export const createOrder = (data) => {
  return axiosInstance.post(API_URL, data);
};

export const updateOrder = (id, data) => {
  return axiosInstance.put(`${API_URL}/${id}`, data);
};

export const deleteOrder = (id) => {
  return axiosInstance.delete(`${API_URL}/${id}`);
};
