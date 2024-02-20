package com.example.cuoiki;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.widget.Toast;

public class AirplaneModeReceiver extends BroadcastReceiver {
    @Override
    public void onReceive(Context context, Intent intent) {
        boolean isAirplaneModeOn = intent.getBooleanExtra("state", false);

        if (isAirplaneModeOn) {
            Toast.makeText(context, "Airplane mode vừa Bật", Toast.LENGTH_SHORT).show();
        } else {
            Toast.makeText(context, "Airplane mode vừa Tắt", Toast.LENGTH_SHORT).show();
        }
    }
}
