package com.example.cuoiki.retrofit;

import com.example.cuoiki.model.Data;
import com.example.cuoiki.model.Data2;
import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import java.util.List;

import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;
import retrofit2.http.Body;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.Query;

public interface ApiRetrofit {
    String ipAddress = "192.168.208.1";

    Gson gson = new GsonBuilder().setDateFormat("dd-MM-yyy").create();
    ApiRetrofit apiService = new Retrofit.Builder()
            .baseUrl("http://" + ipAddress + ":8000/")
            .addConverterFactory(GsonConverterFactory.create(gson))
            .build()
            .create(ApiRetrofit.class);

    @GET("api/rooms")
    Call<List<Data>> getListData();

    @GET("api/customers")
    Call<List<Data2>> getListData2();

    @GET("api/room_store")
    Call<ResponseBody> createRoom(
            @Query("name") String name,
            @Query("room_type_id") int roomTypeId,
            @Query("price") int price
    );
}
