import os

def extract_map_optimized():
    output_filename = "map.txt"
    root_dir = os.getcwd()

    target_directories = [
        "app",
        "config",
        "routes"
    ]

    target_specific_files = [
    
    ]

    ignore_extensions = {'.min.js', '.min.css', '.map', '.lock', '.png', '.jpg', '.jpeg', '.svg', '.ico', '.woff', '.ttf', '.eot', 'sql'}
    ignore_files_exact = {'package-lock.json', 'composer.lock', '.env', 'README.md', 'LICENSE'}

    print(f"Start...: {root_dir}")
    print("Target Dirs:", target_directories)
    print("Target Files:", target_specific_files)

    count_files = 0

    try:
        with open(output_filename, 'w', encoding='utf-8') as outfile:
            outfile.write("="*50 + "\n")
            outfile.write(f"PROJECT MAP\n")
            outfile.write("="*50 + "\n\n")

            for filename in target_specific_files:
                file_path = os.path.join(root_dir, filename)
                
                if os.path.exists(file_path):
                    try:
                        with open(file_path, 'r', encoding='utf-8') as infile:
                            content = infile.read()
                            outfile.write(f"\n{'='*20} START: {filename} {'='*20}\n")
                            outfile.write(content)
                            outfile.write(f"\n{'='*20} END: {filename} {'='*20}\n\n")
                            print(f"Added: {filename}")
                            count_files += 1
                    except Exception as e:
                        print(f"Error: Could not read {filename} -> {e}")
                else:
                    print(f"WARNING: Specified file not found -> {filename}")

            for target_dir in target_directories:
                full_target_path = os.path.join(root_dir, target_dir)
                
                if not os.path.exists(full_target_path):
                    print(f"WARNING: Directory not found, skipping -> {target_dir}")
                    continue

                for dirpath, dirnames, filenames in os.walk(full_target_path):
                    if 'cache' in dirpath.split(os.sep):
                        continue

                    for filename in filenames:
                        if filename in ignore_files_exact:
                            continue
                        
                        if filename.endswith(tuple(ignore_extensions)) or '.min.' in filename:
                            continue

                        file_path = os.path.join(dirpath, filename)
                        relative_path = os.path.relpath(file_path, root_dir)

                        try:
                            with open(file_path, 'r', encoding='utf-8') as infile:
                                content = infile.read()
                                outfile.write(f"\n{'='*20} START: {relative_path} {'='*20}\n")
                                outfile.write(content)
                                outfile.write(f"\n{'='*20} END: {relative_path} {'='*20}\n\n")
                                print(f"Added: {relative_path}")
                                count_files += 1
                        except UnicodeDecodeError:
                            pass
                        except Exception as e:
                            print(f"Error: {relative_path} -> {e}")

        print(f"\n--- PROCESS COMPLETED ---")
        print(f"Total {count_files} files processed.")
        print(f"Output file: {output_filename}")

    except Exception as main_e:
        print(f"Critical error: {main_e}")

if __name__ == "__main__":
    extract_map_optimized()