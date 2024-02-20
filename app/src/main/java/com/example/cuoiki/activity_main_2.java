package com.example.cuoiki;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.Bundle;
import android.util.Log;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.example.cuoiki.adapter.DataAdapter;
import com.example.cuoiki.adapter.DataAdapter2;
import com.example.cuoiki.model.Data2;
import com.example.cuoiki.retrofit.ApiRetrofit;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class activity_main_2 extends AppCompatActivity {
    private RecyclerView rcvTodo;
    private List<Data2> listtodo2;
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
        listtodo2 = new ArrayList<>();
        airplaneModeReceiver = new AirplaneModeReceiver();
        IntentFilter intentFilter = new IntentFilter(Intent.ACTION_AIRPLANE_MODE_CHANGED);
        registerReceiver(airplaneModeReceiver, intentFilter);
        laydulieutodo();
    }




    private void laydulieutodo(){
        ApiRetrofit.apiService.getListData2().enqueue(new Callback<List<Data2>>() {

            @Override
            public void onResponse(Call<List<Data2>> call, Response<List<Data2>> response) {
                listtodo2 = response.body();
                DataAdapter2 todoAdapter2 = new DataAdapter2(listtodo2);
                rcvTodo.setAdapter(todoAdapter2);
            }
            @Override
            public void onFailure(Call<List<Data2>> call, Throwable t) {
                Log.e("API Error", "Error in API call", t);
                Toast.makeText(activity_main_2.this,"Máy không có mạng, thử lại sau",Toast.LENGTH_LONG).show();
            }
        });
    }
}
