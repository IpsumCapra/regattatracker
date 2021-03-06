package nl.regattatracker.android;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.Color;
import android.net.Uri;
import android.os.Bundle;
import android.view.View;
import android.webkit.CookieManager;
import android.webkit.WebResourceError;
import android.webkit.WebResourceRequest;
import android.webkit.WebResourceResponse;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.LinearLayout;

public class MainActivity extends Activity {
    private WebView webviewPage;
    private LinearLayout disconnectedPage;

    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setTitle(getResources().getString(R.string.app_name));
        setContentView(R.layout.activity_main);

        // Webview page
        webviewPage = (WebView)findViewById(R.id.main_webview_page);
        webviewPage.setBackgroundColor(Color.TRANSPARENT);

        WebSettings webSettings = webviewPage.getSettings();
        webSettings.setJavaScriptEnabled(true);

        // Disconnected page
        disconnectedPage = (LinearLayout)findViewById(R.id.main_disconnected_page);

        View.OnClickListener refreshOnClick = (View view) -> {
            webviewPage.reload();
        };
        ((ImageButton)findViewById(R.id.main_disconnected_refresh_button)).setOnClickListener(refreshOnClick);
        ((Button)findViewById(R.id.main_disconnected_hero_button)).setOnClickListener(refreshOnClick);

        // Webview handlers
        webviewPage.setWebViewClient(new WebViewClient() {
            @SuppressWarnings("deprecation")
            public boolean shouldOverrideUrlLoading(WebView view, String url) {
                return shouldOverrideUrlLoading(view, Uri.parse(url));
            }

            public boolean shouldOverrideUrlLoading(WebView view, WebResourceRequest request) {
                return shouldOverrideUrlLoading(view, request.getUrl());
            }

            private boolean shouldOverrideUrlLoading(WebView view, Uri uri) {
                if (uri.getScheme().equals("https") && uri.getHost().equals("test.regattatracker.nl")) {
                    return false;
                } else {
                    try {
                        startActivity(new Intent(Intent.ACTION_VIEW, uri));
                        return true;
                    } catch (Exception exception) {
                        exception.printStackTrace();
                        return false;
                    }
                }
            }

            @SuppressWarnings("deprecation")
            public void onReceivedError(WebView view, int errorCode, String description, String failingUrl) {
                onReceivedError(view);
            }

            public void onReceivedError(WebView view, WebResourceRequest webResourceRequest, WebResourceError webResourceError) {
                if (webResourceRequest.isForMainFrame()) {
                    onReceivedError(view);
                }
            }

            private void onReceivedError(WebView view) {
                view.stopLoading();

                if (disconnectedPage.getVisibility() == View.GONE) {
                    webviewPage.setVisibility(View.GONE);
                    disconnectedPage.setVisibility(View.VISIBLE);
                }
            }

            public void onPageStarted(WebView view, String url, Bitmap favicon) {
                if (disconnectedPage.getVisibility() == View.VISIBLE) {
                    disconnectedPage.setVisibility(View.GONE);
                    webviewPage.setVisibility(View.VISIBLE);
                }

                super.onPageStarted(view, url, favicon);
            }

            public void onPageFinished(WebView view, String url) {
                CookieManager.getInstance().flush();

                super.onPageFinished(view, url);
            }
        });

        Intent intent = getIntent();
        if (intent.getAction() == Intent.ACTION_VIEW) {
            webviewPage.loadUrl(intent.getDataString());
        } else {
            webviewPage.loadUrl("https://test.regattatracker.nl/");
        }
    }

    public void onNewIntent(Intent intent) {
        super.onNewIntent(intent);
        if (intent.getAction() == Intent.ACTION_VIEW) {
            webviewPage.loadUrl(intent.getDataString());
        }
    }

    public void onBackPressed() {
        if (disconnectedPage.getVisibility() == View.VISIBLE) {
            super.onBackPressed();
        }

        if (Uri.parse(webviewPage.getUrl()).getPath().equals("/")) {
            super.onBackPressed();
        }

        if (webviewPage.canGoBack()) {
            webviewPage.goBack();
        } else {
            super.onBackPressed();
        }
    }
}
