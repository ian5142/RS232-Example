package rs232.example;

//import jssc.SerialPortException;

/**
 * Creates a SeriesTwo and CheckDB objects
 * calls the various methods in both classes
 * @author Ian Van Schaick
 */
public class RS232Tester {

    /**
     * Creates a SeriesTwo and CheckDB objects
     * calls the various methods in both classes
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
//        char c = 'C';
//        byte b = 3;
//        System.out.println(c + " is equal to " + b);]

////Test Code
        
//        String line = test2.read();
//        
//        System.out.println(line);
                try {
                    SeriesTwo test2 = new SeriesTwo();
//                    test2.readAck();
            for (int j = 0; j<10; j++) {
                CheckDB test = new CheckDB();
                if (!test.selectisUpdated()) {
                    String message = test.selectMessage();
                    if (test.selectscrollON())  {
                        message = Character.toString((char) 25) + message;
                    }
                    test2.write(message);
                    
                    System.out.println("The message is: " + message);
                    System.out.println("Isupdated is: " + test.selectisUpdated());
                    boolean acknowledge = test2.readAck();
                    //System.out.println("Acknowledged: " + acknowledge);
                    test.setisUpdated();
                    System.out.println("Isupdated is: " + test.selectisUpdated());
                }
                Thread.sleep(60 * 1000);
            }
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
    }
    
}
