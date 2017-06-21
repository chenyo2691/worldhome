/**
 * Created by CYS on 2017/6/17.
 */
function zeroPadded(val) {
    if (val >= 10)
        return val;
    else
        return '0' + val;
}

/**
 * 获取LocalTime
 * @returns {string}
 */
function getlocaltime() {
    var d = new Date();
    var localtime = d.getFullYear() + "-" + zeroPadded(d.getMonth() + 1) + "-" + zeroPadded(d.getDate()) + "T" + zeroPadded(d.getHours()) + ":" + zeroPadded(d.getMinutes()) + ":" + zeroPadded(d.getSeconds());
    return localtime;
}

/**
 * 获取今天日期
 * @returns {string}
 */
function getCurrentDate() {
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    return today;
}

/**
 * 判断字符串包含
 * @param str
 * @param substr
 * @returns {boolean}
 */
function isContains(str, substr) {
    return new RegExp(substr).test(str);
}

/**
 * 字符串转Boolean
 * @param str
 * @returns {boolean}
 * @constructor
 */
function String2Boolean(str) {
    if (str == "true") {
        return true;
    } else {
        return false;
    }
}