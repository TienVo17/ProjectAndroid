package com.example.cuoiki;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.example.cuoiki.adapter.DataAdapter;
import com.example.cuoiki.model.Data;
import com.example.cuoiki.retrofit.ApiRetrofit;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class MainActivity extends AppCompatActivity {
    private RecyclerView rcvTodo;
    private List<Data> listtodo;
    private AirplaneModeReceiver airplaneModeReceiver;

    @SuppressLint("SetTextI18n")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        rcvTodo = findViewById(R.id.rcv_todolist);
        LinearLayoutManager linearLayoutManager = new LinearLayoutManager(this);
        rcvTodo.setLayoutManager(linearLayoutManager);
        DividerItemDecoration itemDecoration = new DividerItemDecoration(this,DividerItemDecoration.VERTICAL);
        rcvTodo.addItemDecoration(itemDecoration);
        listtodo = new ArrayList<>();
        airplaneModeReceiver = new AirplaneModeReceiver();
        IntentFilter intentFilter = new IntentFilter(Intent.ACTION_AIRPLANE_MODE_CHANGED);
        registerReceiver(airplaneModeReceiver, intentFilter);
        laydulieutodo();

        Button btnGetData = findViewById(R.id.btn_add_room);

        // Đặt sự kiện khi nút được nhấn
        btnGetData.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainActivity.this, newroom_activity.class);
                startActivity(intent);
            }
        });
    }




    private void laydulieutodo(){
        ApiRetrofit.apiService.getListData().enqueue(new Callback<List<Data>>() {

            @Override
            public void onResponse(Call<List<Data>> call, Response<List<Data>> response) {
                listtodo = response.body();
                DataAdapter todoAdapter = new DataAdapter(listtodo);
                rcvTodo.setAdapter(todoAdapter);
            }
            @Override
            public void onFailure(Call<List<Data>> call, Throwable t) {
                Log.e("API Error", "Error in API call", t);
                Toast.makeText(MainActivity.this,"Máy không có mạng, thử lại sau",Toast.LENGTH_LONG).show();
            }
        });
    }
}
