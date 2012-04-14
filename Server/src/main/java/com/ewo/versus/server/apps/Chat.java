package com.ewo.versus.server.apps;

import com.ewo.versus.server.App;
import com.ewo.versus.server.Server;
import java.util.HashMap;
import java.util.Map;
import org.codehaus.jackson.JsonNode;
import org.webbitserver.WebSocketConnection;

/**
 * Application de gestion de chat
 * 
 * @author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */
public class Chat extends App {
    
    private final static String JSON_ACTION = "action";
    private final static String JSON_TOKEN = "token";
    private final static String JSON_ID = "id";
    private final static String JSON_MESSAGE = "message";
    private final static String JSON_NAME = "name";
    private final static String ACTION_LOG = "log";
    private final static String ACTION_SEND = "send";
    private Map<String, String> id_client = new HashMap<String, String>();
    private Map<String, String> id_name = new HashMap<String, String>();
    
    public Chat(Server s) {
        super(s);
    }
    
    public void open(WebSocketConnection connection) {
    }
    
    public void close(WebSocketConnection connection) {
        String id_ws = connection.httpRequest().id().toString();
        if (this.id_client.containsKey(id_ws)) {
            String name = this.id_name.get(id_ws);
            
            this.id_client.remove(id_ws);
            this.id_name.remove(id_ws);
            
            System.out.println(name + " s'est déconnecté");
        }
    }
    
    public void message(WebSocketConnection connection, JsonNode json) {
        String action = json.get(JSON_ACTION).asText();
        String id_ws = connection.httpRequest().id().toString();
        if (action.equals(ACTION_SEND) && this.id_client.containsKey(id_ws)) {
            this.processSend(connection, json);
        } else if (action.equals(ACTION_LOG)) {
            this.processLog(connection, json);
        }
    }

    /**
     * S'occupe de l'envoie de message
     * @param connection
     * @param json 
     */
    protected void processSend(WebSocketConnection connection, JsonNode json) {
        String id_ws = connection.httpRequest().id().toString();
        String message = "{\"name\":"
                + "\"" + id_name.get(id_ws) + "\""
                + ",\"message\":"
                + "\"" + json.get(JSON_MESSAGE).asText() + "\"}";
        this.broadcast(connection, message);
    }

    /**
     * S'occupe de la connexion
     * @param connection
     * @param json 
     */
    protected void processLog(WebSocketConnection connection, JsonNode json) {
        String id_ws = connection.httpRequest().id().toString();
        
        String id = json.get(JSON_ID).asText();
        String token = json.get(JSON_TOKEN).asText();
        
        JsonNode response = this.checkKey(id);
        //TODO : ajouter un check non vide
        if (response != null) {
            //Récupération des infos
            JsonNode token_response_json = response.get(JSON_TOKEN);
            JsonNode name_response_json = response.get(JSON_NAME);

            //Vérification
            if (token_response_json != null
                    && name_response_json != null
                    && token_response_json.asText().equals(token)) {
                String name_response = name_response_json.asText();
                //On ajoute
                this.id_client.put(id_ws, id);
                this.id_name.put(id_ws, name_response);
                System.out.println(name_response + " s'est logué");
            }
        }
    }
    
    protected void broadcast(WebSocketConnection connection, String message) {
        for (String k : this.id_client.keySet()) {
            this.clients.get(k).send(message); // echo back message in upper case
        }
    }

    /**
     * Cette fonction permet d'obtenir le tokken d'une personne
     * Elle est sécurisée via une clé privée qui permet d'obtenir une réponse de la part de l'application en php
     * 
     * @param   id  identifiant de l'utilisateur à checker
     * @return un noeud JSon
     */
    protected JsonNode checkKey(String id) {
        Map<String, String> params = new HashMap<String, String>();
        params.put("id", id);
        params.put("key", "CHANGER LA CLEF");
        
        return this.sendPostHttpRequestJSon("client/chat/check_token", params);
    }
}
