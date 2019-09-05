/**
 * 转换日期为指定分隔符字符串
 * @param {JSON} jsonData 
 * {
 * dateString: [必需] 指定日期,
 * seperator: [可选] 指定分隔符
 * }
 */
function transferDateString(jsonData) {
  var dd = new Date(jsonData.dateString);
  var sep = jsonData.seperator ? jsonData.seperator : "-";
  var result = dd.getFullYear() + sep + ("0" + (dd.getMonth() + 1)).slice(-2) + sep + ("0" + dd.getDate()).slice(-2);
  return result;
}

/**
 * 获取指定cookie键的值
 * @param key 指定要获取的cookie键
 */
function getCookie(key) {
  var arr, reg = new RegExp("(^| )" + key + "=([^;]*)(;|$)");
  if (arr = document.cookie.match(reg)) {
    return unescape(arr[2]);
  } else {
    return null;
  }
}

/**
 * 设置浏览器Cookie，默认不设置过期时间，浏览器关闭时清除
 * @param key cookie键
 * @param value cookie值
 * @param expires cookie过期时间，以秒为单位，默认为0，即不设置过期时间，浏览器关闭时清除
 */
function setCookie(key, value, expires = 0) {
  var cookie = key + "=" + escape(value);
  if (expires) {
    var date = new Date();
    date.setTime(date.getTime() + expires * 1000);
    cookie = cookie + ";expires=" + date.toGMTString();
  }
  document.cookie = cookie;
}

/**
 * 清除指定cookie键的值
 * @param key 指定要清除的cookie键
 **/
function delCookie(key) {
  var date = new Date();
  date.setTime(date.getTime() - 1000);
  document.cookie = key + "='';expires=" + date.toGMTString();
}