// src/api/postOfficeApi.js
import axiosInstance from "./axiosInstance";

const API_URL = "/api/postoffices";

export const getPostOffices = (search = "", page = 1) => {
  return axiosInstance.get(`${API_URL}?search=${search}&page=${page}`);
};

export const getPostOffice = (id) => {
  return axiosInstance.get(`${API_URL}/${id}`);
};

export const createPostOffice = (data) => {
  return axiosInstance.post(API_URL, data);
};

export const updatePostOffice = (id, data) => {
  return axiosInstance.put(`${API_URL}/${id}`, data);
};

export const deletePostOffice = (id) => {
  return axiosInstance.delete(`${API_URL}/${id}`);
};
