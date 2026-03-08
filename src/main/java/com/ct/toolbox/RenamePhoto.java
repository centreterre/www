package com.ct.toolbox;

import lombok.SneakyThrows;

import java.io.File;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.Comparator;
import java.util.HashSet;
import java.util.List;
import java.util.Set;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import java.util.stream.Collectors;
import java.util.stream.Stream;

public class RenamePhoto {

    File baseDir = new File("./mayang2026/blog/pages/007");

    public static void main(String[] args) {
        new RenamePhoto().run();
    }

    private void run() {
        Set<String> exists = new HashSet<>();
        listFiles(baseDir).stream()
                .filter(v -> v.getName().startsWith("PHOTO"))
                .forEach(file -> {
                    String regex = "^(PHOTO)\\s(\\d{2})(\\p{Lower})?\\.(jpe?g)$";
                    Pattern pattern = Pattern.compile(regex, Pattern.CASE_INSENSITIVE);
                    Matcher matcher = pattern.matcher(file.getName());
                    if (matcher.matches()) {
                        String number = matcher.group(2);
                        String v = matcher.group(3);
//                        if (exists.contains(number)) {
//                            number = number + "b";
//                        }
                        String newName = "mayang-2026-blog-007-0" + number + (v == null ? "" : v) + ".jpg";
                        System.out.println(newName);
                        file.renameTo(new File(file.getParentFile(), newName));
//                        exists.add(number);
                    }
                });
    }


    @SneakyThrows
    public List<File> listFiles(File dir) {
        try (Stream<Path> stream = Files.walk(Paths.get(dir.getCanonicalPath()))) {
            return stream
                    .filter(file -> !Files.isDirectory(file))
                    .map(Path::toFile)
                    .sorted(Comparator.comparing(File::getName))
                    .collect(Collectors.toList());
        }
    }

}
