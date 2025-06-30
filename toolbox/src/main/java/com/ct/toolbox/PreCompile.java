package com.ct.toolbox;

import lombok.SneakyThrows;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileOutputStream;
import java.io.FileReader;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.Set;
import java.util.concurrent.atomic.AtomicBoolean;
import java.util.stream.Collectors;
import java.util.stream.Stream;

import static java.util.Optional.ofNullable;
import static org.apache.commons.lang3.StringUtils.LF;
import static org.apache.commons.lang3.StringUtils.trimToNull;

public class PreCompile {

    File baseDir = new File("./mayang2026/news");

    public static void main(String[] args) {
        new PreCompile().run();
    }

    private void run() {
        listFiles(baseDir).forEach(file -> {
            System.out.println("Compiling " + file);
            compile(file);
        });
    }

    @SneakyThrows
    private String compile(BufferedReader bufferedReader) {
        StringBuilder out = new StringBuilder();
        String line = bufferedReader.readLine();
        AtomicBoolean closeParagraph = new AtomicBoolean();
        while (line != null) {
            ofNullable(trimToNull(line)).ifPresent(v -> {
                if (v.startsWith("#")) {
                    if (closeParagraph.get()) out.append("}").append(LF);
                    if (v.startsWith("###")) {
                        out.append("{ 3 ").append(v.substring(3).trim()).append(" }").append(LF);
                    } else if (v.startsWith("##")) {
                        out.append("{ 1 ").append(v.substring(2).trim()).append(" }").append(LF);
                    } else if (v.startsWith("#")) {
                        out.append("{ 2 ").append(v.substring(1).trim()).append(" }").append(LF);
                    }
                    closeParagraph.set(false);
                } else {
                    if (v.startsWith("$")) {
                        if (closeParagraph.get()) out.append("}").append(LF);
                        out.append("{ ").append(v.substring(1).trim().split(" ")[0]).append(LF);
                    } else if (v.startsWith("!")) {
                        if (!closeParagraph.get()) out.append("{ 12").append(LF);
                        String w = v.substring(1).trim();
                        String img = w.split(" ")[0];
                        String legend = w.replace(img, "").trim();
                        out.append("[").append(img).append("/@").append(legend).append("]").append(LF);
                    } else {
                        if (!closeParagraph.get()) out.append("{ 12").append(LF);
                        out.append(v.trim()).append(LF);
                    }
                    closeParagraph.set(true);
                }
            });
            line = bufferedReader.readLine();
        }
        return out.append("}").append(LF).toString().replace("…", "...").replace("’", "'");
    }

    @SneakyThrows
    public Set<File> listFiles(File dir) {
        try (Stream<Path> stream = Files.walk(Paths.get(dir.getCanonicalPath()))) {
            return stream
                    .filter(file -> !Files.isDirectory(file))
                    .map(Path::toFile)
                    .filter(file -> file.getName().endsWith(".smd"))
                    .collect(Collectors.toSet());
        }
    }

    @SneakyThrows
    private void compile(File file) {
        File parentDir = file.getParentFile();
        String output = compile(new BufferedReader(new FileReader(file)));
        File outputFile = new File(parentDir, file.getName().replace(".smd", ".txt"));
        new FileOutputStream(outputFile).write(output.getBytes(StandardCharsets.UTF_8));
    }
}
