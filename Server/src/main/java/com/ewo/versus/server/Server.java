package com.ewo.versus.server;

import com.ewo.versus.server.apps.Chat;
import java.lang.reflect.InvocationTargetException;
import java.util.HashMap;
import java.util.Map;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.webbitserver.WebServer;
import org.webbitserver.WebServers;

/**
 *
 * @author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */
public class Server {

    private final int port;
    private final WebServer webServer;
    
    private Map<String, Class<? extends App>> apps = new HashMap<String, Class<? extends App>>();

    Server(int port) {
        this.port = port;
        webServer = WebServers.createWebServer(this.port);
    }
    
    /**
     * Ajoute une nouvelle application sur le serveur
     * 
     * @param path : chemin de l'appli. Par exemple, sur localhost, si path vaut foo, alors l'application sera disponnible sur ws://localhost:port/foo
     * @param c : class de l'application à utiliser
     */
    public void addAppli(String path, Class<? extends App> c){
        this.apps.put(path, c);
    }

    
    /**
     * Lance le serveur. Attention à bien ajouter les applications avant
     * 
     */
    public void run() {
        //Première étape, ajouter les applications
        try {
            for(String path : this.apps.keySet()){
                //Un peu de réflexion :D
                java.lang.reflect.Constructor constructeur = 
                             this.apps.get(path).getConstructor (new Class [] {Server.class});
                App app = (App) constructeur.newInstance (new Object [] {this});
                this.webServer.add(path, app);
                Logger.getLogger(Server.class.getName()).log(
                        Level.INFO, "Application {0} d\u00e9mar\u00e9e sur {1}",
                        new Object[]{this.apps.get(path).getName(),
                            path});
            }
            
        } catch (InstantiationException ex) {
            Logger.getLogger(Server.class.getName()).log(Level.SEVERE, null, ex);
        } catch (IllegalAccessException ex) {
            Logger.getLogger(Server.class.getName()).log(Level.SEVERE, null, ex);
        } catch (IllegalArgumentException ex) {
            Logger.getLogger(Server.class.getName()).log(Level.SEVERE, null, ex);
        } catch (InvocationTargetException ex) {
            Logger.getLogger(Server.class.getName()).log(Level.SEVERE, null, ex);
        } catch (NoSuchMethodException ex) {
            Logger.getLogger(Server.class.getName()).log(Level.SEVERE, null, ex);
        } catch (SecurityException ex) {
            Logger.getLogger(Server.class.getName()).log(Level.SEVERE, null, ex);
        }
        
        System.out.println("Server démarré");
        webServer.start();
    }
}
