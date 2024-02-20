package com.example.cuoiki.adapter;

import android.content.Context;
import android.content.DialogInterface;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.recyclerview.widget.RecyclerView;

import com.example.cuoiki.MainActivity;
import com.example.cuoiki.R;
import com.example.cuoiki.model.Data;

import java.util.List;

public class DataAdapter extends  RecyclerView.Adapter<DataAdapter.DataViewHolder> {

    private final List<Data> mListData;

    public DataAdapter(List<Data> mListData) {
        this.mListData = mListData;
    }

    public DataViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_data,parent,false);
        return new DataViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull DataViewHolder holder, int position) {
        Data data = mListData.get(position);
        if(data == null){
            return;
        }
        holder.tvId.setText("Id: " + String.valueOf(data.getId()));
        holder.tvTitle.setText(data.getName());

        holder.tvUserId.setText(String.valueOf(data.getId()));
        holder.tvComplete.setText(data.getPrice() + ".000 vnđ");

        holder.itemView.setOnLongClickListener(new View.OnLongClickListener() {
            @Override
            public boolean onLongClick(View v) {
                Context context = v.getContext();
                hienthiDialog(holder.getAdapterPosition(),context);
                return true;
            }
        });

        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Context context = v.getContext();
                String userID = holder.tvUserId.getText().toString();
                Toast.makeText(context,"User id là: "+userID,Toast.LENGTH_SHORT).show();
            }
        });
    }
    private void hienthiDialog(final int position,Context context) {
        AlertDialog.Builder builder = new AlertDialog.Builder(context);
        builder.setTitle("Xác nhận xóa");
        builder.setMessage("Có thực sự muốn xóa todo này không?");

        builder.setPositiveButton("Có", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                xoaItemRcv(position);
            }
        });

        builder.setNegativeButton("Không", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
            }
        });

        builder.create().show();
    }

    private void xoaItemRcv(int position) {
        mListData.remove(position);
        notifyItemRemoved(position);
    }

    @Override
    public int getItemCount() {
        if(mListData != null){
            return mListData.size();
        }
        return 0;
    }

    public static  class DataViewHolder extends RecyclerView.ViewHolder{

        private final TextView tvId,tvTitle,tvComplete,tvUserId;

        public DataViewHolder(@NonNull View itemView) {
            super(itemView);
            tvId = itemView.findViewById(R.id.tv_id);
            tvTitle = itemView.findViewById(R.id.tv_title);
            tvComplete = itemView.findViewById(R.id.tv_completed);
            tvUserId = itemView.findViewById(R.id.tv_userId);
        }
    }
}
