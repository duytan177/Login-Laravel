import React, { useEffect } from 'react';
import Cookies from 'js-cookie';
function AdminHome() {
  useEffect(() => {
    const userSessionCookie = Cookies.get('user_session');
    if (!userSessionCookie) {
      window.location.href = '/login/user';
    }
}, []); // Chỉ chạy một lần khi component được render

  return (
    <div>
      <h1>Trang chính của quản trị viên</h1>
      <p>Xin chào, quản trị viên!</p>
    </div>
  );
}

export default AdminHome;