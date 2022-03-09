import request from '@/utils/request'

export function upload(data) {
  return request({
    url: '/admin/uploads',
    method: 'post',
    data
  })
}

export function uploadBase64(data) {
  return request({
    url: '/admin/upload/base64',
    method: 'post',
    data
  })
}
