/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package rs232.sign.control;

/**
 *
 * @author Ian Van Schaick
 */
public class SeriesTwoTester {
    public static void main(String[] args) {
        SeriesTwo test2 = new SeriesTwo();
        String calculateChksum = test2.calculateChksum("This is a test.");
    }
}
