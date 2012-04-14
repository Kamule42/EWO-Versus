package com.ewo.versus.server;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.net.URL;
import java.net.URLConnection;
import java.net.URLEncoder;
import java.util.HashMap;
import java.util.Map;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.codehaus.jackson.JsonNode;
import org.codehaus.jackson.map.ObjectMapper;
import org.webbitserver.BaseWebSocketHandler;
import org.webbitserver.WebSocketConnection;


/**
 * Classe qui va décrire une application. Chaque application a pour but de gèrer une action en particulier
 * 
 * @author Benjamin Herbomez <benjamin.herbomez@esial.com>
 * @version 0.1
 */
public abstract class App extends BaseWebSocketHandler {
    
    private final Server server;
    protected Map<String, WebSocketConnection> clients = new HashMap<String, WebSocketConnection>();
    
    public App(Server s){
        super();
        this.server = s;
    }
    
    @Override
    public void onOpen(WebSocketConnection connection) {
        this.clients.put(connection.httpRequest().id().toString(), connection);
        this.open(connection);
    }

    @Override
    public void onClose(WebSocketConnection connection) {
        this.clients.remove(connection.httpRequest().id().toString());
        this.close(connection);
    }

    @Override
    public void onMessage(WebSocketConnection connection, String message) {
        this.message(connection, this.toJSon(message));
    }
    
    /**
     * Cette fonction est appelée à chaque fois qu'un utilisateur se connecte
     * 
     * @param   connection  la connexion http
     */
    public abstract void open(WebSocketConnection connection);
    /**
     * Cette fonction est appelée à chaque fois qu'un utilisateur se déconnecte
     * 
     * @param connection    la connexion http
     */
    public abstract void close(WebSocketConnection connection);
    /**
     * Cette fonction est appelée à chaque fois qu'un utilisateur envoie un message
     * 
     * @param connection    la connexion http
     * @param json          le message au format JSon, ce qui permet de passer plusieurs variables
     */
    public abstract void message(WebSocketConnection connection, JsonNode json);
    
    /**
     * Cette fonction permet d'envoyer une requête http de type POST
     *
     * @param   cible   controller a appeler
     * @param   params  variables à mettre dans le POST
     * 
     * @return  la réponse http
     */
    protected String sendPostHttpRequest(String cible, Map<String, String> params){
        String r = "";
        try {
            // Construct data
            String data = null;
            for(String k : params.keySet()){
                if(data == null)
                    data = "";
                else data += "&";
                data += URLEncoder.encode(k, "UTF-8") + "=" + URLEncoder.encode(params.get(k), "UTF-8");
            }
           
            
            // Send data
            URL url = new URL(Main.BASE_URL+cible);
            URLConnection conn = url.openConnection();
            conn.setDoOutput(true);
            OutputStreamWriter wr = new OutputStreamWriter(conn.getOutputStream());
            wr.write(data);
            wr.flush();

            // Get the response
            BufferedReader rd = new BufferedReader(new InputStreamReader(conn.getInputStream()));
            r = rd.readLine();
            wr.close();
            rd.close();
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
        return r;
    }

    /**
     * Cette fonction permet d'envoyer une requête http de type POST
     *
     * @param   cible   controller a appeler
     * @param   params  variables à mettre dans le POST
     * 
     * @return  la réponse http parsée au format JSon
     */
    protected JsonNode sendPostHttpRequestJSon(String cible, Map<String, String> params){
        return this.toJSon(this.sendPostHttpRequest(cible, params));
    }
    
    /**
     * Fonction qui parse une chaine au format JSon
     * 
     * @param message la chaine à parser
     * @return un objet JSon si le parse a réussi, null sinon
     */
    protected JsonNode toJSon(String message){
        try {
            ObjectMapper mapper = new ObjectMapper();
            return mapper.readValue(message, JsonNode.class);
        } catch (IOException ex) {
            Logger.getLogger(App.class.getName()).log(Level.SEVERE,"*********" + message);
            Logger.getLogger(App.class.getName()).log(Level.SEVERE, null, ex);
        } 
        return null;
    }
}
