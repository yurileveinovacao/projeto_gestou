package br.com.leveinovacao.gestou;

import com.google.androidbrowserhelper.trusted.LauncherActivity;

public class GestouLauncherActivity extends LauncherActivity {
    @Override
    protected android.net.Uri getLaunchingUrl() {
        return android.net.Uri.parse("https://gestou.leveinovacao.com.br/app/login");
    }
}
