import request from '@/utils/request'

export function getHandleLogs(data) {
  return request({
    url: '/admin/handle/logs',
    method: 'get',
    params: data
  })
}
