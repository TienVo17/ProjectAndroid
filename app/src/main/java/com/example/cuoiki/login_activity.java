package com.example.cuoiki;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

public class login_activity extends Activity {

    private EditText editTextUsername;
    private EditText editTextPassword;
    private Button buttonLogin;
    private Button buttonCustomer;
    private Button buttonRoom;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.login_activity);

        // Ánh xạ các thành phần từ layout
        editTextUsername = findViewById(R.id.editTextUsername);
        editTextPassword = findViewById(R.id.editTextPassword);
        buttonLogin = findViewById(R.id.buttonLogin);
        buttonCustomer = findViewById(R.id.buttonCustomer);
        buttonRoom = findViewById(R.id.buttonRoom);

        // Ẩn các nút Customer và Room ban đầu
        buttonCustomer.setVisibility(View.GONE);
        buttonRoom.setVisibility(View.GONE);

        // Thiết lập sự kiện cho nút Đăng nhập
        buttonLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                // Lấy dữ liệu từ EditText
                String username = editTextUsername.getText().toString();
                String password = editTextPassword.getText().toString();

                // Kiểm tra tài khoản và mật khẩu
                if (username.equals("admin") && password.equals("admin")) {
                    // Nếu tài khoản là admin và mật khẩu là admin, hiển thị các nút Customer và Room
                    buttonCustomer.setVisibility(View.VISIBLE);
                    buttonRoom.setVisibility(View.VISIBLE);
                    editTextUsername.setVisibility(View.GONE);
                    editTextPassword.setVisibility(View.GONE);
                    buttonLogin.setVisibility(View.GONE);
                    // Hiển thị thông báo
                    showToast("Đăng nhập thành công!");
                } else {
                    // Nếu tài khoản hoặc mật khẩu không đúng, hiển thị thông báo lỗi
                    showToast("Sai tên đăng nhập hoặc mật khẩu!");
                }
            }
        });
        buttonCustomer.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                // Mở màn hình Customer
                Intent intent = new Intent(login_activity.this, MainActivity.class);
                startActivity(intent);
            }
        });

        // Thiết lập sự kiện cho nút Room
        buttonRoom.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                // Mở màn hình Room
                Intent intent = new Intent(login_activity.this, activity_main_2.class);
                startActivity(intent);
            }
        });
    }

    private void showToast(String message) {
        Toast.makeText(this, message, Toast.LENGTH_SHORT).show();
    }
}
