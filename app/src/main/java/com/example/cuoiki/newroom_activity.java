package com.example.cuoiki;

import static android.content.ContentValues.TAG;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.example.cuoiki.adapter.DataAdapter;
import com.example.cuoiki.adapter.DataAdapter2;
import com.example.cuoiki.model.Data;
import com.example.cuoiki.model.Data2;
import com.example.cuoiki.retrofit.ApiRetrofit;

import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;

import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class newroom_activity extends AppCompatActivity {


    @SuppressLint("SetTextI18n")

    private EditText editTextName;
    private EditText editTextRoomType;
    private EditText editTextPrice;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.newroom_activity);

        // Khởi tạo EditTexts
        editTextName = findViewById(R.id.editTextRoomName);
        editTextRoomType = findViewById(R.id.editTextRoomType);
        editTextPrice = findViewById(R.id.editTextPrice);

        // Khởi tạo nút
        Button btnGetData = findViewById(R.id.btnCreate);

        // Đặt sự kiện khi nút được nhấn
        btnGetData.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // Gọi phương thức để xử lý dữ liệu
                processData();
            }
        });
    }

    private void processData() {
        // Lấy dữ liệu từ EditTexts
        String name = editTextName.getText().toString();
        String roomTypeText = editTextRoomType.getText().toString();
        String priceText = editTextPrice.getText().toString();

        int roomType = Integer.parseInt(roomTypeText);
        int price = Integer.parseInt(priceText);
        String conect = "http://192.168.208.1:8000/api/room_store?name="+name+"&room_type_id="+roomType+"&price="+price;
        new CallApiTask().execute(conect);
        showToast("thêm thành công");


        Intent intent = new Intent(newroom_activity.this, MainActivity.class);
        startActivity(intent);

    }

    private void showToast(String message) {
        Toast.makeText(this, message, Toast.LENGTH_SHORT).show();
    }

    private static class CallApiTask extends AsyncTask<String, Void, Void> {

        @Override
        protected Void doInBackground(String... params) {
            String urlString = params[0];
            try {
                // Tạo một đối tượng URL từ đường dẫn
                URL url = new URL(urlString);

                // Mở kết nối HTTP
                HttpURLConnection urlConnection = (HttpURLConnection) url.openConnection();
                try {
                    // Thực hiện yêu cầu
                    InputStream in = urlConnection.getInputStream();
                    // Đọc dữ liệu nếu cần thiết, nhưng trong trường hợp này, chúng ta không cần
                    // Nếu bạn muốn đọc dữ liệu, bạn có thể sử dụng BufferedReader hoặc các thư viện khác.

                } finally {
                    // Đóng kết nối khi hoàn thành
                    urlConnection.disconnect();
                }
            } catch (IOException e) {
                e.printStackTrace();
            }
            return null;
        }
    }

}

