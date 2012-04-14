package com.ewo.versus.server;

import com.ewo.versus.server.apps.Chat;
import java.io.IOException;

public class Main extends Thread {

    public final static String BASE_URL = "http://78.249.2.88:8080/versus/";
    
    public static void main(String[] args) throws IOException {
        Server serv = new Server(8088);
            serv.addAppli("/chat", Chat.class);
        serv.run();
    }
}
