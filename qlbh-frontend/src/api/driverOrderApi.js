// src/api/driverOrderApi.js
import axiosInstance from "./axiosInstance";

const API_URL = "/api/driver-orders";

export const getDriverOrders = (search = "", page = 1) => {
  return axiosInstance.get(`${API_URL}?search=${search}&page=${page}`);
};

export const getDriverOrder = (id) => {
  return axiosInstance.get(`${API_URL}/${id}`);
};

export const createDriverOrder = (data) => {
  return axiosInstance.post(API_URL, data);
};

export const updateDriverOrder = (id, data) => {
  return axiosInstance.put(`${API_URL}/${id}`, data);
};

export const deleteDriverOrder = (id) => {
  return axiosInstance.delete(`${API_URL}/${id}`);
};
